<?php

namespace Lucid\Http\Controllers\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lucid\Http\Controllers\Controller;

class PostsController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function user($username)
   {
      $user_exists = DB::table('users')->where('name', $username)->orWhere('username', $username)->get();
      if (!isset($user_exists[0])) {
         return false;
      }
      return $user_exists[0];
   }
   /**
    * Save Posts
    *
    * @param Request $request
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    */
   public function savePost(Request $request)
   {
      $request->validate([
         'body' => 'required'
      ]);

      $title = '';
      $body = $request->body;
      // filter out non-image data

      $images = '';

      $extra = '';
      $username = auth()->user()->username;
      $post = new \Lucid\Core\Document($username);
      $result = $post->create($title, $body, $tag = '', $images, $extra, $postType = 'micro-blog');

      return redirect($username . '/thoughts')->with('msg', 'Post Published');
   }


   public function publish(Request $request, $username)
   {

      $title = $request->title ?? '';
      $body = $request->postVal;
      $tags = $request->tags;


      $initial_images = array_filter($request->all(), function ($key) {
         return preg_match('/^img-\w*$/', $key);
      }, ARRAY_FILTER_USE_KEY);

      $images = [];
      foreach ($initial_images as $key => $value) {
         $newKey = str_replace('/_/', '.', $key);
         $images[$newKey] = $value;
      }

      $extra = "";
      $app = new \Lucid\Core\Document($username);
      $result = $app->create($title, $body, $tags, $images, $extra, $postType = 'full-blog');
      return json_encode($result);
   }

   public function posts($username)
   {

      $fcheck = "no";

      if (Auth::user() && $username === Auth::user()->username) {

         if (!$this->user($username)) {
            return abort(404);
         }


         $user = $this->user($username);
         $app = new \Lucid\Core\Document($username);
         $posts = $app->get('posts');


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

         $check = new \Lucid\Core\Subscribe(Auth::user()->username);
         $fcheck = $check->followCheck($user->name);

         return view('post', compact('user', 'posts'), ['fcheck' => $fcheck, 'fcount' => $fcount, 'count' => $count]);
      }
      return redirect('/' . $username);


   }

   public function singlePostPage($username, $postTitle)
   {
      if (!$this->user($username)) {
         return abort(404);
      }
      $user = $this->user($username);
      $app = new \Lucid\Core\Document($username);
      $post = $app->getPost($postTitle);

      if (!$post) {
         return redirect('/' . $username . '/home');
      }

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

      return view('single-blog-post', compact('post', 'user'), ['fcheck' => $fcheck, 'fcount' => $fcount, 'count' => $count]);
   }


}
