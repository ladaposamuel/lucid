<?php

namespace Lucid\Http\Controllers\Users;

use Illuminate\Http\Request;
use Lucid\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }


   public function subscribe()
   {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];

      $post = [];
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount = $sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
         $fcount = count($fcount);
      } else {
         $fcount = '';
      }
      if (!empty($count)) {
         $count = count($count);
      } else {
         $count = '';
      }


      //User Follower checker
      if (Auth::user()) {
         $check = new \Lucid\Core\Subscribe(Auth::user()->username);
         $fcheck = $check->followCheck($user->name);
      } else {
         $fcheck = 'no';
      }

      return view('subscribe', ['fcheck' => $fcheck, 'user' => $user, 'fcount' => $fcount, 'count' => $count]);

   }

   public function saveSubscriptionEmail(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'email' => 'required|email'
      ]);

      if ($validator->fails()) {
         return response()->json($validator->messages());
      }

      $insert = DB::table('maillists')->insert([
         'email' => $request->email
      ]);

      if ($insert) {
         return response()->json(['success' => 'Thanks For Subscribing To Our Newsletters']);
      }


   }


}
