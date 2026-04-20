<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user with this google_id already exists
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Login existing user
                Auth::login($user);
            } else {
                // Check if user with this email already exists
                $userByEmail = User::where('email', $googleUser->email)->first();

                if ($userByEmail) {
                    // Update existing email user with google_id
                    $userByEmail->update([
                        'google_id' => $googleUser->id,
                    ]);
                    Auth::login($userByEmail);
                } else {
                    // Create new user
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => bcrypt(\Illuminate\Support\Str::random(16)), // Random password for new user
                    ]);
                    
                    // Mark as verified immediately as Google has verified it
                    $newUser->email_verified_at = now();
                    $newUser->save();

                    Auth::login($newUser);
                }
            }

            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan Google. Silakan coba lagi.');
        }
    }
}
