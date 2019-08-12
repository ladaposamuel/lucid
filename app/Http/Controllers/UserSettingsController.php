<?php

namespace Lucid\Http\Controllers;

use Lucid\user_settings;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
  /**
    * Create a new Setting instance.
    *
    * @param  Request  $request
    * @return Response
    */
   public function store(Request $request)
   {
       // Validate the request...

       $Setting = new user_settings();

       $Setting->user_id = $request->user_id;
       $Setting->user_path = $request->user_path;
       $Setting->setting_path = $request->setting_path;

       $Setting->save();
      // return ;
   }
}
