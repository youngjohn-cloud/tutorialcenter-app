<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // Redirect for Students
    public function redirectToGoogleStudent()
    {
        return Socialite::driver('google')
            ->stateless()
            ->with([
                'state' => 'student',
                'prompt' => 'select_account consent',
                'include_granted_scopes' => 'true'
            ])->redirect();
    }

    // Redirect for Guardians
    public function redirectToGoogleGuardian()
    {
        return Socialite::driver('google')
            ->stateless()
            ->with([
                'state' => 'guardian',
                'prompt' => 'select_account consent',
                'include_granted_scopes' => 'true'
            ])->redirect();
    }

    // Shared Callback
    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = $request->input('state'); // "student" or "guardian"
        $nameParts = explode(' ', $googleUser->name ?? '');
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        try {
            //checks what user used the google sign in auth
            if ($user === 'guardian') {
                Guardian::updateOrCreate(
                    ['email' => $googleUser->getEmail()],
                    [
                        'firstname' => $firstName,
                        'lastname'  => $lastName,
                        'email'     => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'provider'  => 'google',
                        'email_verified_at' => now(),
                        'password'  => bcrypt(Str::random(16)),
                        'profile_picture' => $googleUser->avatar,
                    ]
                );

                return redirect()->away("https://tutorialcenter.vercel.app/parent-dashboard");
            }

            // default = student
            $user = Student::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'firstname' => $firstName,
                    'lastname'  => $lastName,
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'provider'  => 'google',
                    'email_verified_at' => now(),
                    'password'  => bcrypt(Str::random(16)),
                    'profile_picture' => $googleUser->avatar,
                ]
            );

            return redirect()->away("https://tutorialcenter.vercel.app/dashboard");
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during login', 'error' => $e->getMessage()], 500);
        }
    }
}
