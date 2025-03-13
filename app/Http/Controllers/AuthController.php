<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!str_ends_with($googleUser->email, '@moh.gov.my')) {
                return redirect('/login')->withErrors(['email' => 'Only Kementerian Kesihatan staff can register.']);
            }

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                session(['google_name' => $googleUser->name, 'google_email' => $googleUser->email]);
                return redirect('/register');
            }

            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Google login failed.']);
        }
    }

    public function registerUser(Request $request)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'username.required' => 'The username field is required.',
            'username.unique' => 'This username is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ];
    
        // Validate input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ], $messages);
    
        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password), // Encrypt password
        ]);
    
        // Redirect to login page with success message
        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }
    


    public function loginUser(Request $request)
{
    // Validate input
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt login
    if (Auth::attempt($credentials)) {
        return redirect('/')->with('success', 'Login successful!');
    }

    // If login fails, return an error
    return back()->withErrors(['login' => 'Invalid credentials.']);
}




public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validate input
    $request->validate([
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'skim' => 'nullable|in:Pakar,Pegawai Perubatan,Farmasi,Pergigian',
        'gred' => 'nullable|string',
        'fasiliti' => 'nullable|string',
        'jabatan' => 'nullable|string',
        'pengalaman' => 'nullable|integer',
        'jenis_fasiliti' => 'nullable|string',
        'negeri' => 'nullable|string'
    ]);

    // Update user fields
    $user->update([
        'skim' => $request->skim,
        'gred' => $request->gred,
        'fasiliti' => $request->fasiliti,
        'jabatan' => $request->jabatan,
        'pengalaman' => $request->pengalaman,
        'jenis_fasiliti' => $request->jenis_fasiliti,
        'negeri' => $request->negeri
    ]);

    return redirect('/profile')->with('success', 'Profile updated successfully!');
}


}
