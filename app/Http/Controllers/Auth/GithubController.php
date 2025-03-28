<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class GithubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $socialUser = Socialite::driver('github')->user();
            
            // Handle potential null email (GitHub allows private emails)
            $email = $socialUser->email ?? $socialUser->nickname . '@github.user';

            $user = User::updateOrCreate(
                ['provider_id' => $socialUser->id],
                [
                    'name' => $socialUser->name ?? $socialUser->nickname,
                    'email' => $email,
                    'provider' => 'github',
                    'avatar' => $socialUser->avatar,
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(24))
                ]
            );

            if (!$user->hasAnyRole(Role::all())) {
                $user->assignRole('reader');
            }

            Auth::login($user, true);
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            Log::error('GitHub Auth Error: ' . $e->getMessage());
            return redirect('/login')->withErrors('GitHub login failed: ' . $e->getMessage());
        }
    }
}