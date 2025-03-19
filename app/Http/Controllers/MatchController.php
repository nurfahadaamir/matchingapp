<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMatch;
use App\Models\IneligibleUser;
use App\Models\MatchRequest;
use App\Notifications\MatchDeclinedNotification;



class MatchController extends Controller
{
    

    public function findMatch(Request $request)
    {
        $user = Auth::user();
        $preferredState = $request->query('state');
    
        // Check if user is ineligible
        if (IneligibleUser::where('user_id', $user->id)->exists()) {
            return redirect('/profile')->with('error', 'Anda tidak layak untuk pertukaran.');
        }
    
        // Find a matching user
        $match = User::where('skim', $user->skim)
                     ->where('gred', $user->gred)
                     ->where('negeri', $preferredState)
                     ->whereNotIn('id', UserMatch::pluck('matched_user_id')->toArray())
                     ->whereNotIn('id', MatchRequest::where('sender_id', $user->id)
                     ->where('status', 'matched')
                     ->pluck('receiver_id')) // ✅ Exclude only matched users, NOT declined ones
                     ->where('id', '!=', $user->id)
                     ->whereNotIn('id', IneligibleUser::pluck('user_id')->toArray())
                     ->orderBy('created_at', 'asc')
                     ->first();
    
        if ($match) {
            // Create match record
            $userMatch = UserMatch::create([
                'user_id' => $user->id,
                'matched_user_id' => $match->id
            ]);
    
            UserMatch::create([
                'user_id' => $match->id,
                'matched_user_id' => $user->id
            ]);
    
            // Redirect to supervisor input form
            return redirect()->route('match.supervisor.form', ['match_id' => $userMatch->id]);
        } else {
            return view('match-not-found', compact('preferredState'));
        }
    }
    

    public function cancelMatch()
{
    $user = Auth::user();

    // Find the match
    $matchRequest = MatchRequest::where(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
    })->where('status', 'matched')->first();

    if (!$matchRequest) {
        return back()->with('error', 'No active match found.');
    }

    // Get the matched user
    $matchedUserId = ($matchRequest->sender_id == $user->id) ? $matchRequest->receiver_id : $matchRequest->sender_id;

    // Set match_id to NULL for both users
    User::where('id', $user->id)->update(['match_id' => null]);
    User::where('id', $matchedUserId)->update(['match_id' => null]);

    // Delete match request record
    $matchRequest->delete();

    return back()->with('success', 'Match canceled successfully.');
}

    
public function saveSupervisorDetails(Request $request, $match_id)
{
    $request->validate([
        'penyelia_name' => 'required|string|max:255',
        'penyelia_email' => 'required|email',
        'penyelia_phone' => 'required|string|max:15',
        'ketua_jabatan_name' => 'required|string|max:255',
        'ketua_jabatan_email' => 'required|email',
        'ketua_jabatan_phone' => 'required|string|max:15',
    ]);

    $match = UserMatch::findOrFail($match_id);

    $match->update([
        'penyelia_name' => $request->penyelia_name,
        'penyelia_email' => $request->penyelia_email,
        'penyelia_phone' => $request->penyelia_phone,
        'ketua_jabatan_name' => $request->ketua_jabatan_name,
        'ketua_jabatan_email' => $request->ketua_jabatan_email,
        'ketua_jabatan_phone' => $request->ketua_jabatan_phone,
    ]);

    return redirect('/profile')->with('success', 'Supervisor and department head details updated successfully.');
}

public function showSupervisorForm($match_id)
{
    $match = UserMatch::findOrFail($match_id);
    return view('match.supervisor-form', compact('match'));
}

public function showStateSelection()
    {
        return view('match.state-selection');
    }

    // ✅ Step 2: Show available matches **only after the user selects a state**
    public function showAvailableMatches(Request $request)
    {
        $user = Auth::user();
        $preferredState = $request->query('state');

        // ❌ Check if user is ineligible
        if (IneligibleUser::where('user_id', $user->id)->exists()) {
            return redirect('/profile')->with('error', 'Anda tidak layak untuk pertukaran.');
        }
        $requestedUserIds = MatchRequest::where('sender_id', $user->id)->pluck('receiver_id')->toArray();
        // ✅ Get IDs of ineligible users
        $ineligibleUserIds = IneligibleUser::pluck('user_id')->toArray();

        // ✅ Get available matches with the same Skim, Gred, & Negeri
        $availableMatches = User::where('skim', Auth::user()->skim)
                        ->where('gred', Auth::user()->gred)
                        ->where('negeri', $preferredState) 
                        ->whereNotIn('id', $requestedUserIds) // Exclude requested users
                        ->whereNotIn('id', $ineligibleUserIds) // ✅ Exclude ineligible users
                        ->where('id', '!=', Auth::id()) 
                        ->get();

                            

        return view('matches.available-matches', compact('availableMatches', 'preferredState'));
    }

public function sendMatchRequest($receiver_id)
{
    $user = Auth::user();

    // Check if request already exists
    if (MatchRequest::where('sender_id', $user->id)->where('receiver_id', $receiver_id)->exists()) {
        return back()->with('error', 'You have already sent a match request to this user.');
    }

    // Create a new match request
    MatchRequest::create([
        'sender_id' => $user->id,
        'receiver_id' => $receiver_id,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Match request sent!');
}

public function viewMatchRequests()
{
    $user = Auth::user();

    // Incoming Requests (Users who sent a request to this user)
    $incomingRequests = MatchRequest::where('receiver_id', $user->id)->where('status', 'pending')->get();

    // Sent Requests (Requests this user has sent)
    $sentRequests = MatchRequest::where('sender_id', $user->id)->where('status', 'pending')->get();

    return view('matches.match-requests', compact('incomingRequests', 'sentRequests'));
}

public function acceptMatch($sender_id)
{
    $user = Auth::user(); // User who is accepting the match

    // ✅ Find the match request
    $matchRequest = MatchRequest::where('sender_id', $sender_id)
                                ->where('receiver_id', $user->id)
                                ->where('status', 'pending')
                                ->first();

    if (!$matchRequest) {
        return back()->with('error', 'No pending match request found.');
    }

    // ✅ Update match request status for both users
    MatchRequest::where('sender_id', $sender_id)
                ->where('receiver_id', $user->id)
                ->update(['status' => 'matched']);

    MatchRequest::where('sender_id', $user->id)
                ->where('receiver_id', $sender_id)
                ->update(['status' => 'matched']);

    // ✅ Update both users' match_id in the users table
    $user->match_id = $sender_id;
    $user->save();

    $matchedUser = User::find($sender_id);
    $matchedUser->match_id = $user->id;
    $matchedUser->save();

    // ✅ Create match entries in `user_matches` table for both users
    UserMatch::updateOrCreate(
        ['user_id' => $user->id],
        ['matched_user_id' => $sender_id]
    );

    UserMatch::updateOrCreate(
        ['user_id' => $sender_id],
        ['matched_user_id' => $user->id]
    );

    return redirect()->route('profile')->with('success', 'Congratulations! You have found your match.');
}

public function declineMatch($sender_id)
{
    $user = Auth::user(); // This is the receiver (User B) who is declining

    // Find the match request
    $matchRequest = MatchRequest::where('sender_id', $sender_id)
                                ->where('receiver_id', $user->id)
                                ->where('status', 'pending')
                                ->first();

    if (!$matchRequest) {
        return back()->with('error', 'No pending match request found.');
    }

    // ✅ Delete the request instead of just updating it
    $matchRequest->delete();

    // ✅ Notify the sender (User A)
    $sender = User::find($sender_id);
    if ($sender) {
        $sender->notify(new MatchDeclinedNotification($user->name));
    }

    return back()->with('success', 'You have declined the match request.');
}



}

