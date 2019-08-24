<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use DB;
use Storage;

class HomeController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $user = Auth::user();
      $username = $user['username'];
      $post = new \Lucid\Core\Document($username);
      $feed = $post->fetchRss();
      // print_r($feed);
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount = $sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
         $fcount = count($fcount);
      } else {
         $fcount = "";
      }
      if (!empty($count)) {
         $count = count($count);
      } else {
         $count = "";
      }


      //User Follower checker
      if (Auth::user()) {
         $check = new \Lucid\Core\Subscribe(Auth::user()->username);
         $fcheck = $check->followCheck($user->name);
      } else {
         $fcheck = "no";
      }

      return view('home', ['fcheck' => $fcheck, 'posts' => $feed, 'fcount' => $fcount, 'count' => $count]);

   }

   public function timeline($username)
   {
      $user = Auth::user();
      $fcount = '';
      $count = '';
      $post = new \Lucid\Core\Document($username);
      $post = $post->fetchAllRss();

      if ($username === $user->username) {
         $username = $user->username;


         // follower and following Count
         $sub = new \Lucid\Core\Subscribe($username);
         $fcount = $sub->myfollowercount();
         $count = $sub->count();
         //dd($fcount);
         if (!empty($fcount)) {
            $fcount = count($fcount);
         }
         if (!empty($count)) {
            $count = count($count);
         }


         //User Follower checker
         if (Auth::user()) {
            $check = new \Lucid\Core\Subscribe(Auth::user()->username);
            $fcheck = $check->followCheck($user->name);
         } else {
            $fcheck = "no";
         }

         return view('timeline', ['posts' => $post, 'fcheck' => $fcheck, 'user' => $user, 'fcount' => $fcount, 'count' => $count]);
      }

      return view($user->username . '/timeline', ['posts' => $post, 'user' => $user, 'fcount' => $fcount, 'count' => $count]);


   }

   public function construction()
   {
      return view('under-construction');
   }
}
