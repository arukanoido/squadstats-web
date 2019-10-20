<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use kanalumaddela\LaravelSteamLogin\Http\Controllers\AbstractSteamLoginController;
use kanalumaddela\LaravelSteamLogin\SteamUser;

use App\Models\User;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
        $user = User::where('id', $steamUser->steamId)->first();

        if (!$user) {
            $steamUser->getUserInfo();

            $user = User::create([
                'id' => $steamUser->steamId,
                'name' => $steamUser->name,
                'verified' => true
            ]);
        }

        // login the user using the Auth facade
        Auth::login($user, true);
    }
}
