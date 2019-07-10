<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class pageController extends Controller
{
    public function user($username) {
        $user_exists = DB::table('users')->where('name',$username)->orWhere('username',$username)->get();
        if(!isset($user_exists[0])) {
            return false;
        }
        return $user_exists[0];
    }

    public function homePage($username)
    {
        $ziki = new \Lucid\Core\Document($username);
        $feed =$ziki->fetchRss();
        if(!$this->user($username)) {
            return "=======404=========";
        }
        $user = $this->user($username);
        return view('home', ['posts' => $feed,'user'=>$user]);

    }

    public function singlePostPage($username,$postTitle){
        if(!$this->user($username)) {
            return "=======404=========";
        }
        $user = $this->user($username);
        $app  = new \Lucid\Core\Document($username);
        $post=$app->getPost($postTitle);

        if(!$post){
            return redirect('/'.$username.'/home');
        }
        return view('single-blog-post',compact('post','user'));
    }
}
