<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; 
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
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
            
            $user = User::updateOrCreate([
                'provider' => 'github',
                'provider_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name ?? $socialUser->nickname,
                'email' => $socialUser->email,
                'avatar' => $socialUser->avatar,
                'role' => 'reader',
                'password' => bcrypt(Str::random(16))
            ]);

            Auth::login($user);
            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors('GitHub login failed: ' . $e->getMessage());
        }
    }
}
