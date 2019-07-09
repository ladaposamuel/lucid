<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Lucid\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
    	return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider){
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   User::where(['email' => $userSocial->getEmail()])->first();
        if($users){
            Auth::login($users);
            $username = preg_split('/ +/', $users->name);
            $dir = strtolower($username[0]);
            return redirect("/{$dir}/home");
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
            $username = preg_split('/ +/', $user->name);
            $dir = strtolower($username[0]);
            return redirect("/{$dir}/home");
            // to fix
            // redirect to a route where the username would be set
         return redirect()->route('home');
        }
    }


}
