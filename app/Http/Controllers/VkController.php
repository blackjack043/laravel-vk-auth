<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VkController extends Controller
{
    public function callback() {
        $user = Socialite::driver('vkontakte')->user();
        $email = $user->getEmail();
        $name = $user->getName();
        $password = Hash::make('12345677890');
        $u = User::firstOrCreate(['email' => $email, 'name' => $name],['email' => $email, 'name' => $name, 'password' => $password]);
        $userDB = User::where('email','=',$email)->first();
        if($u) {
            $u->email = $email;
            $u->save();
            \Auth::login($userDB, true);
        };
        return redirect()->route('welcome');
    }
}
