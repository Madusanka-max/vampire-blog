<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; 
use App\Models\User; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'provider' => 'google',
                'avatar' => $socialUser->avatar,
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(24))
            ]);

            if (!$user->hasAnyRole(Role::all())) {
                $user->assignRole('reader');
            }

            Auth::login($user, true);
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            Log::error('Google Auth Error: '.$e->getMessage());
            return redirect('/login')->withErrors('Login failed: '.$e->getMessage());
        }
    }
}