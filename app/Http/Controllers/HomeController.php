<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
          // $count = new \Lucid\Core\Subscribe();
               $fcount = 1;
           //    $count = $count->count();
        return view('home', ['posts' => $feed]);

    }
    public function timeline($username)
    {
      $user = Auth::user();
      if ($username == $user->username) {

      $username = $user->username;
      $post = new \Lucid\Core\Document($username);

            $post = $post->fetchAllRss();
            //$count = $count->count();
          //  print_r($post);
         // $count = new \Lucid\Core\Subscribe();
              $fcount = 1;
              $count = 1;
     return view('timeline', ['posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);
     }else {

        return view($user->username.'/timeline', ['posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }
  }
    public function userimage($id, $image)
    {
        return Image::make(storage_path() . '/' . $id . '/images' . $image)->response();
    }


    public function thoughts($username)
    {
      $user = Auth::user();
      if ($username == $user->username) {

      $username = $user->username;
      $post = new \Lucid\Core\Document($username);

            $post = $post->fetchAllRss();
            //$count = new Ziki\Core\Subscribe();
            //$fcount = $count->fcount();
            //$count = $count->count();
          //  print_r($post);
        //  $count = new \Lucid\Core\Subscribe();
              $fcount = 1;
          $count = 1;
     return view('thoughts', ['posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);
     }else {

       return redirect($user->username.'/thoughts');
     }

    }

/*
*
*
*

*/



    public function savePost(Request $request)
    {
      //dd($request->all());

      $this->validate($request, [
        'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
      ]);

      $title = isset($request->title) ? $request->title : '';
      $body = $request->body;
      // filter out non-image data

      $images = $request->file('file');

      $extra = "";
      $user = Auth::user();
      $username = $user->username;
      $post = new \Lucid\Core\Document($username);
      $result = $post->create($title, $body, $tag="", $images, $extra);
      return redirect($username.'/timeline')->with('msg', 'Post Published');
    }

    public function subscribe()
    {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];
      
      $post=[];
        
      $fcount = 1;
      $count = 1;
      return view('subscribe', ['user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }


    public function publish(Request $request,$username) {

        $title = isset($request->title) ? $request->title : '';
        $body = $request->postVal;
        $tags = $request->tags;
      
        
          $initial_images = array_filter($request->all(), function ($key) {
            return preg_match('/^img-\w*$/', $key);
        }, ARRAY_FILTER_USE_KEY);
        
        $images = [];
        foreach ($initial_images as $key => $value) {
            $newKey = preg_replace('/_/', '.', $key);
            $images[$newKey] = $value;
        }
      
        $extra = "";
        $app = new \Lucid\Core\Document($username);
        $result = $app->create($title, $body, $tags, $images, $extra);
        return json_encode($result);
    }


    

}
