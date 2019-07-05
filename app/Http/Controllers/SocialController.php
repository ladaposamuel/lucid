<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
    	return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial 	=   Socialite::driver($provider)->stateless()->user();
        $users       	=   User::where(['email' => $userSocial->getEmail()])->first();

        if($users){
            Auth::login($users);
            $login_user = array("name" => Auth::user()->name, "email" => Auth::user()->email, "pic" => Auth::user()->image);
             json_encode($login_user);
            return redirect()->to('/auth')->send($login_user)->with('success');
        }else{

            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
            $login_user = array("name" => $user->name, "email" => $user->email, "pic" => $user->image);
            return redirect()->to('/auth?s=done')->send();
          //  Redirect::to("/auth?s=done");
          //  Redirect::to("https://localhost:8000/login/{$provider}/callback?data={$login_user}");
        }
    }


}
