<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMatch;
use App\Models\BlockedMatch;





class MatchController extends Controller
{
    

    public function findMatch(Request $request)
    {
        $user = Auth::user();
        $preferredState = $request->query('state');
    
        // Check if the user is already matched
        if (UserMatch::where('user_id', $user->id)->exists()) {
            return redirect('/profile')->with('error', 'You have already been matched.');
        }
    
        // Get blocked users
        $blockedUsers = BlockedMatch::where('user_id', $user->id)->pluck('blocked_user_id');
    
        // Find the earliest available match who is not blocked
        $match = User::where('skim', $user->skim)
                     ->where('gred', $user->gred)
                     ->where('negeri', $preferredState)
                     ->whereNotIn('id', $blockedUsers) // ✅ Exclude blocked users
                     ->whereNotIn('id', UserMatch::pluck('matched_user_id')->toArray()) // ✅ Exclude already matched users
                     ->where('id', '!=', $user->id) // ✅ Exclude self
                     ->orderBy('created_at', 'asc') // ✅ Oldest registered user first
                     ->first();
    
        if ($match) {
            // ✅ Store the match in the matches table
            UserMatch::create([
                'user_id' => $user->id,
                'matched_user_id' => $match->id
            ]);
    
            UserMatch::create([
                'user_id' => $match->id,
                'matched_user_id' => $user->id
            ]);
    
            return view('match-found', compact('match', 'preferredState'));
        } else {
            return view('match-not-found', compact('preferredState'));
        }
    }
    

public function cancelMatch()
{
    $user = Auth::user();
    $match = UserMatch::where('user_id', $user->id)->first();

    if ($match) {
        // Find the matched user
        $matchedUser = User::find($match->matched_user_id);

        if ($matchedUser) {
            // Store in blocked matches so they never match again
            BlockedMatch::create([
                'user_id' => $user->id,
                'blocked_user_id' => $matchedUser->id
            ]);
            BlockedMatch::create([
                'user_id' => $matchedUser->id,
                'blocked_user_id' => $user->id
            ]);

            // Remove match from both users
            UserMatch::where('user_id', $user->id)->delete();
            UserMatch::where('user_id', $matchedUser->id)->delete();
        }

        return redirect('/profile')->with('success', 'Match cancelled. You will not be matched with this user again.');
    }

    return redirect('/profile')->with('error', 'No match found.');
}

}

