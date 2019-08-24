<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class pageController extends Controller
{
   public function user($username)
   {
      $user_exists = DB::table('users')->where('name', $username)->orWhere('username', $username)->get();
      if (!isset($user_exists[0])) {
         return false;
      }
      return $user_exists[0];
   }

   public function index($username)
   {
      if (!$this->user($username)) {
         return abort(404);
      }
      $user = $this->user($username);

      if (Auth::user() && Auth::user()->username == $username) {
         $user = Auth::user();
         $username = $user->username;

         $post = new \Lucid\Core\Document($username);
         $following = $post->subscription();
         $follower = $post->subscriber();
         $post = $post->Feeds();
         //$post =[];
         $sub = new \Lucid\Core\Subscribe($username);
         $fcount = $sub->myfollowercount();
         if (!empty($fcount)) {
            $fcount = count($fcount);
         } else {
            $fcount = "";
         }
         $fcheck = $sub->followCheck($user->name);

         $count = $sub->count();
         if (!empty($count)) {
            $count = count($count);
         } else {
            $count = "";
         }


         //dd($fcheck);
         return view('timeline', ['posts' => $post, 'fcheck' => $fcheck, 'user' => $user, 'fcount' => $fcount, 'count' => $count, 'following' => $following, 'follower' => $follower]);

      } else {


         $app = new \Lucid\Core\Document($username);
         $feed = $app->Feeds();

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
         //  $follower = $app->subscription();
         //dd($follower);

         $userposts = $app->get('posts');

         return view('home', ['posts' => $feed, 'user' => $user, 'fcheck' => $fcheck, 'fcount' => $fcount, 'count' => $count, "userposts" => $userposts]);

      }


   }


   public function contact($username)
   {
      if (!$this->user($username)) {
         return abort(404);
      }

      $user = $this->user($username);
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount = $sub->myfollowercount();
      $count = $sub->count();
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
         $fcheck = 'no';
      }


      $contact = DB::table('contact_settings')->where('user_id', $user->id)->first();


      return view('contact', compact('user', 'contact'), ['fcheck' => $fcheck, 'fcount' => $fcount, 'count' => $count]);
   }


   public function thoughts($username)
   {
      if (!$this->user($username)) {
         return abort(404);
      }

      $user = $this->user($username);
      $post = new \Lucid\Core\Document($username);
      $post = $post->get('micro-blog-posts');
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

      return view('thoughts', ['fcheck' => $fcheck, 'posts' => $post, 'user' => $user, 'fcount' => $fcount, 'count' => $count]);

   }

   public function following($username)
   {
      if (!$this->user($username)) {
         return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
      $following = $post->subscription();
      $follower = $post->subscriber();
      $post = $post->fetchAllRss();
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
         $myfollower = $check->followerArray();
         //    dd($myfollower);
      } else {
         $fcheck = "no";
         $myfollower = [];
      }

      return view('follow-details', [
         'fcheck' => $fcheck,
         'posts' => $post,
         'user' => $user,
         'fcount' => $fcount,
         'count' => $count,
         'following' => $following,
         'follower' => $follower,
         'followerArray' => $myfollower
      ]);
   }

   public function followers($username)
   {
      if (!$this->user($username)) {
         return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
      $following = $post->subscription();
      $follower = $post->subscriber();
      $post = $post->fetchAllRss();
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
//dd($following);

      //User Follower checker
      if (Auth::user()) {
         $check = new \Lucid\Core\Subscribe(Auth::user()->username);
         $fcheck = $check->followCheck($user->name);
         $myfollower = $check->followerArray();
//dd($myfollower);
      } else {
         $fcheck = "no";
         $myfollower = [];
      }

      return view('follow-details', [
         'fcheck' => $fcheck,
         'posts' => $post,
         'user' => $user,
         'fcount' => $fcount,
         'count' => $count,
         'following' => $following,
         'follower' => $follower,
         'followerArray' => $myfollower
      ]);
   }


}
