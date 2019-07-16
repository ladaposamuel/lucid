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
        
        if(!$this->user($username)) {
            return "=======404=========";
        }
        $app = new \Lucid\Core\Document($username);
        $feed =$app->fetchRss();
        $user = $this->user($username);
      
            $fcount = 1;
            $count = 1;
         $userposts=$app->get();
         return view('home', ['posts' => $feed,'user'=>$user,'fcount'=>$fcount, 'count' => $count,"userposts"=>$userposts]);

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
      
        $fcount = 1;
        $count = 1;
        return view('single-blog-post',compact('post','user'),['fcount'=>$fcount, 'count' => $count ]);
    }

    public function posts($username){
        if(!$this->user($username)) {
            return '========404========';
        }

        $user = $this->user($username);
        $app  = new \Lucid\Core\Document($username);
        $posts=$app->get();
    
            $fcount = 1;
         
            $count = 1;
        return view('post',compact('user','posts'), ['fcount'=>$fcount, 'count' => $count ]);
    }

    public function contact($username){
        if(!$this->user($username)) {
            return '========404========';
        }

        $user = $this->user($username);

        $fcount = 1;
         
        $count = 1;

        return view('contact',compact('user','posts'), ['fcount'=>$fcount, 'count' => $count ]);
    }
}
