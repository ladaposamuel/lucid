<?php

namespace Lucid\Http\Controllers\Auth;

use Lucid\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Storage;
use Socialite;
use Auth;
use Lucid\User;
use Lucid\user_settings;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
      $userSocial =   Socialite::driver($provider)->stateless()->user();
      $users       =   $this->findOrCreateUser($userSocial, $provider);

          Auth::login($users, true);
          $email = $users->email;
          $username = strstr($email, '@', true);
        //  $username = preg_split('/ +/', $username);
          $path = trim($username).'/';
          Storage::makeDirectory($username);

          $this->store_settings($path, $users->id);
          $rss = new \Lucid\Core\Document($username);
            $rss->DemoRSS();
          return redirect()->to("/{$username}");
    }


public function findOrCreateUser($user, $provider){
    $users       =   User::where('provider_id', $user->id)->first();
    if($users){
        return $users;
    }
    $email = $user->email;
    $username = strstr($email, '@', true);

        return User::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'username'      => $username,
            'image'         => $user->avatar,
            'provider_id'   => $user->id,
            'provider'      => $provider,
        ]);

        return $user;
}

public function store_settings($path, $user_id)
{
  $setting       =   user_settings::where('user_id', $user_id)->first();
  if($setting){
      return $setting;
  }
    return  user_settings::create([
        'user_id' => $user_id,
        'user_path' => $path,
        'setting_path' =>"",
    ]);
}

public function logout($username){
    Auth::logout();
    return redirect($username);
}
}
