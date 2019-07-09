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
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];
      $post = new \Lucid\Core\Document($path);
            $feed = $post->fetchRss();

        return view('home', ['posts' => $feed]);

    }
    public function timeline()
    {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];
      $post = new \Lucid\Core\Document($path);
            $post = $ziki->fetchAllRss();
            //$count = new Ziki\Core\Subscribe();
            //$fcount = $count->fcount();
            //$count = $count->count();
//print_r(
  //$post
//);
        return view('timeline', ['posts' => $post]);

    }
    public function microblog()
    {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];
      $post = new \Lucid\Core\Document($path);
            $post = $post->fetchAllRss();
            //$count = new Ziki\Core\Subscribe();
            //$fcount = $count->fcount();
            //$count = $count->count();
//print_r($post);

       return view('microblog', ['posts' => $post]);

    }
    public function savePost(Request $request)
    {
    //  dd($request->all());
$this->validate($request, [
  'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
]);

  $title = isset($request->title) ? $request->title : '';
  $body = $request->body;
  // filter out non-image data

  $images = $request->file('file');

  //return json_encode([$images]);
  $extra = "";
  $directory = storage_path('/contents/');
  $user = Auth::user();
  $username = preg_split('/ +/', $user->name);
  $path = $username[0];
  $post = new \Lucid\Core\Document($path);
  $result = $post->create($title, $body, $images, $extra);
return redirect($path.'/microblog')->with('msg', 'Post Published');
    }

}
