<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;
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
    protected $redirectTo = '/home';

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
          $username = preg_split('/ +/', $users->name);
          return redirect()->to("/{$username[0]}/home");
    }


public function findOrCreateUser($user, $provider){
    $users       =   User::where('provider_id', $user->id)->first();
    if($users){
        return $user;
    }
        return User::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'image'         => $user->avatar,
            'provider_id'   => $user->id,
            'provider'      => $provider,
        ]);


}
}
