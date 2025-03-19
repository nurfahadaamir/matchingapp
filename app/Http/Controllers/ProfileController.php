<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\IneligibleUser;

class ProfileController extends Controller
{
    // ✅ Show profile page
    public function showProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user')); // ✅ Correct path
    }

    public function editProfile()
{
    $user = Auth::user();
    return view('auth.edit-profile', compact('user'));
}



    // ✅ Handle eligibility form submission
    public function updateEligibility(Request $request)
    {
        $user = Auth::user();
        $selectedReasons = $request->input('rules', []);

        if (!empty($selectedReasons)) {
            IneligibleUser::updateOrCreate(
                ['user_id' => $user->id], 
                ['reasons' => json_encode($selectedReasons)]
            );

            return redirect()->back()->with('error', 'Pertukaran Tidak Dibenarkan. Anda tidak layak untuk bertukar.');
        } else {
            // ✅ Remove ineligible status if all checkboxes are unchecked
            IneligibleUser::where('user_id', $user->id)->delete();

            return redirect()->back()->with('success', 'Status kelayakan telah dikemaskini.');
        }
    }

    // ✅ Handle profile updates (with improved file upload)
    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'username' => 'required|string|max:255',
        'skim' => 'required|string',
        'gred' => 'required|string',
        'fasiliti' => 'nullable|string',
        'negeri' => 'required|string',
        'jabatan' => 'nullable|string',
        'pengalaman' => 'nullable|integer|min:0',
        'jenis_fasiliti' => 'nullable|string',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('profile_picture')) {
        $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $profilePicture;
    }

    // ✅ Debugging: Show what is changing
    $oldData = $user->toArray();
    
    $user->update([
        'username' => $request->username,
        'skim' => $request->skim,
        'gred' => $request->gred,
        'fasiliti' => $request->fasiliti,
        'negeri' => $request->negeri,
        'jabatan' => $request->jabatan,
        'pengalaman' => $request->pengalaman,
        'jenis_fasiliti' => $request->jenis_fasiliti,
    ]);

    $user->refresh(); // Reload the user from the database
    
    $newData = $user->toArray();
 // ✅ Return to profile page with success message
 return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}



}
