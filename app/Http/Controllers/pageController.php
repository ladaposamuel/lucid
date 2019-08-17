<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
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
            return abort(404);
        }
        $user = $this->user($username);

        if(Auth::user() && Auth::user()->username ==$username){
                $user = Auth::user();
                $username = $user->username;

                $post = new \Lucid\Core\Document($username);
                $following = $post->subscription();
                $follower = $post->subscriber();
                $post = $post->Feeds();
            //$post =[];
                $count = new \Lucid\Core\Subscribe($username);
                $fcount = $count->fcount();
                $count = new \Lucid\Core\Subscribe($username);


                $fcount =$count->fcount();
                if (!empty($fcount)) {
                    $fcount = count($fcount);
                  }
                  else {
                    $fcount = "";
                  }
          //      dd($count->count());
                $title = [];
                if (!is_null($count->count())) {

                foreach($count->count() as $key => $fuser){
                $title['name'] = $fuser['title'];
                //array_push($title , $title);
              }

        }

                if (in_array($user->name, $title)) {
                  $fcheck = "yes";
                }else {
                  $fcheck = "no";
                }
              //  $data  = $count->count();
                $count = $count->count();
                if (!empty($count)) {
                    $count = count($count);
                  }
                  else {
                    $count = "";
                  }
  //dd($fcheck);
                return view('timeline', ['posts' => $post,'fcheck' => $fcheck,'user'=>$user,'fcount'=>$fcount, 'count' => $count, 'following' => $following, 'follower' => $follower]);

        }else {


            $app = new \Lucid\Core\Document($username);
            $feed =$app->fetchRss();

            $count = new \Lucid\Core\Subscribe($username);


            $fcount =$count->fcount();
            if (!empty($fcount)) {
                $fcount = count($fcount);
              }
              else {
                $fcount = "";
              }

        //    dd($count->count());


if(Auth::user()){
  $check = new \Lucid\Core\Subscribe(Auth::user()->username);
  $title = [];
  if (!is_null($check->fcount())) {

  foreach($check->fcount() as $key => $fuser){
//  $title = $fuser['title'];
  array_push($title , $fuser['title']);
}

            if (in_array($user->name, $title)) {
              $fcheck = "yes";
            }else {
              $fcheck = "no";
            }
          }else {
            $fcheck = "no";
          }
        //  dd($check->fcount());
        }
          else {
            $fcheck = "no";
          }
        //  dd($fcheck);
          //  $data  = $count->count();
            $count = $count->count();
            if (!empty($count)) {
                $count = count($count);
              }
              else {
                $count = "";
              }
            $follower = $app->subscription();

             $userposts=$app->get('posts');

             return view('home', ['posts' => $feed,'user'=>$user,'fcheck' => $fcheck,'fcount'=>$fcount, 'count' => $count,"userposts"=>$userposts]);
        }


    }

    public function singlePostPage($username,$postTitle){
        if(!$this->user($username)) {
            return abort(404);
        }
        $user = $this->user($username);
        $app  = new \Lucid\Core\Document($username);
        $post=$app->getPost($postTitle);

        if(!$post){
            return redirect('/'.$username.'/home');
        }

        $count = new \Lucid\Core\Subscribe($username);


        $fcount =$count->fcount();
        if (!empty($fcount)) {
            $fcount = count($fcount);
          }
          else {
            $fcount = "";
          }
          if(Auth::user()){
            $check = new \Lucid\Core\Subscribe(Auth::user()->username);
            $title = [];
            if (!is_null($check->fcount())) {

            foreach($check->fcount() as $key => $fuser){
          //  $title = $fuser['title'];
            array_push($title , $fuser['title']);
          }

                      if (in_array($user->name, $title)) {
                        $fcheck = "yes";
                      }else {
                        $fcheck = "no";
                      }
                    }else {
                      $fcheck = "no";
                    }
                  //  dd($check->fcount());
                  }
                    else {
                      $fcheck = "no";
                    }

        $count = $count->count();
        if (!empty($count)) {
            $count = count($count);
          }
          else {
            $count = "";
          }
        return view('single-blog-post',compact('post','user'),['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
    }

    public function posts($username){
            if(Auth::user() && $username == Auth::user()->username){

            if(!$this->user($username)) {
                return abort(404);
            }

            $user = $this->user($username);
            $app  = new \Lucid\Core\Document($username);
            $posts=$app->get('posts');
            $count = new \Lucid\Core\Subscribe($username);


            $fcount =$count->fcount();
            if (!empty($fcount)) {
                $fcount = count($fcount);
              }
              else {
                $fcount = "";
              }
            //dd($count->count());
            if(Auth::user()){
              $check = new \Lucid\Core\Subscribe(Auth::user()->username);
              $title = [];
              if (!is_null($check->fcount())) {

              foreach($check->fcount() as $key => $fuser){
            //  $title = $fuser['title'];
              array_push($title , $fuser['title']);
            }

                        if (in_array($user->name, $title)) {
                          $fcheck = "yes";
                        }else {
                          $fcheck = "no";
                        }
                      }else {
                        $fcheck = "no";
                      }
                    //  dd($check->fcount());
                    }
                      else {
                        $fcheck = "no";
                      }

          //  $data  = $count->count();
            $count = $count->count();
            if (!empty($count)) {
                $count = count($count);
              }
              else {
                $count = "";
              }
            return view('post',compact('user','posts'), ['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
        }else {
            return redirect('/'.$username);
        }

    }

    public function contact($username){
        if(!$this->user($username)) {
            return abort(404);
        }

        $user = $this->user($username);
        $count = new \Lucid\Core\Subscribe($username);


        $fcount =$count->fcount();
        if (!empty($fcount)) {
            $fcount = count($fcount);
          }
          else {
            $fcount = "";
          }
          if(Auth::user()){
            $check = new \Lucid\Core\Subscribe(Auth::user()->username);
            $title = [];
            if (!is_null($check->fcount())) {

            foreach($check->fcount() as $key => $fuser){
          //  $title = $fuser['title'];
            array_push($title , $fuser['title']);
          }

                      if (in_array($user->name, $title)) {
                        $fcheck = "yes";
                      }else {
                        $fcheck = "no";
                      }
                    }else {
                      $fcheck = "no";
                    }
                  //  dd($check->fcount());
                  }
                    else {
                      $fcheck = "no";
                    }

        $count = $count->count();
        if (!empty($count)) {
            $count = count($count);
          }
          else {
            $count = "";
          }

          

        $contact = DB::table('contact_settings')->where('user_id',$user->id)->first();


        return view('contact',compact('user','posts','contact'), ['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
    }



    public function thoughts($username)
    {
      if(!$this->user($username)) {
          return abort(404);
      }

      $user = $this->user($username);
      $post = new \Lucid\Core\Document($username);
      $post = $post->get('micro-blog-posts');
      $count = new \Lucid\Core\Subscribe($username);


      $fcount =$count->fcount();
      if (!empty($fcount)) {
          $fcount = count($fcount);
        }
        else {
          $fcount = "";
        }
      //dd($count->count());
      if(Auth::user()){
        $check = new \Lucid\Core\Subscribe(Auth::user()->username);
        $title = [];
        if (!is_null($check->fcount())) {

        foreach($check->fcount() as $key => $fuser){
      //  $title = $fuser['title'];
        array_push($title , $fuser['title']);
      }

                  if (in_array($user->name, $title)) {
                    $fcheck = "yes";
                  }else {
                    $fcheck = "no";
                  }
                }else {
                  $fcheck = "no";
                }
              //  dd($check->fcount());
              }
                else {
                  $fcheck = "no";
                }
    //  $data  = $count->count();
      $count = $count->count();
      if (!empty($count)) {
          $count = count($count);
        }
        else {
          $count = "";
        }
      return view('thoughts', ['fcheck' => $fcheck,'posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }

    public function following($username) {
        if(!$this->user($username)) {
          return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
              $following = $post->subscription();
              $follower = $post->subscriber();
              $post = $post->fetchAllRss();
              $count = new \Lucid\Core\Subscribe($username);
            //  dd($following);
              $fcount = $count->fcount();
              $count = new \Lucid\Core\Subscribe($username);


             $fcount =$count->fcount();
              if (!empty($fcount)) {
                  $fcount = count($fcount);
                }
                else {
                  $fcount = "";
                }
              //dd($count->count());
              if(Auth::user()){
                $check = new \Lucid\Core\Subscribe(Auth::user()->username);
                $title = [];
                if (!is_null($check->fcount())) {

                foreach($check->fcount() as $key => $fuser){
              //  $title = $fuser['title'];
                array_push($title , $fuser['title']);
              }

                          if (in_array($user->name, $title)) {
                            $fcheck = "yes";
                          }else {
                            $fcheck = "no";
                          }
                        }else {
                          $fcheck = "no";
                        }
                      //  dd($check->fcount());
                      }
                        else {
                          $fcheck = "no";
                        }

            //  $data  = $count->count();
              $count = $count->count();
              if (!empty($count)) {
                  $count = count($count);
                }
                else {
                  $count = "";
                }
      return view('follow-details', ['fcheck' => $fcheck,'posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count, 'following' => $following, 'follower' => $follower]);
    }

    public function followers($username) {
        if(!$this->user($username)) {
          return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
                $following = $post->subscription();
                $follower = $post->subscriber();
                $post = $post->fetchAllRss();
                $count = new \Lucid\Core\Subscribe($username);
                $fcount = $count->fcount();
                $count = new \Lucid\Core\Subscribe($username);


                $fcount =$count->fcount();
                if (!empty($fcount)) {
                    $fcount = count($fcount);
                  }
                  else {
                    $fcount = "";
                  }
                //dd($count->count());
                if(Auth::user()){
                  $check = new \Lucid\Core\Subscribe(Auth::user()->username);
                  $title = [];
                  if (!is_null($check->fcount())) {

                  foreach($check->fcount() as $key => $fuser){
                //  $title = $fuser['title'];
                  array_push($title , $fuser['title']);
                }

                            if (in_array($user->name, $title)) {
                              $fcheck = "yes";
                            }else {
                              $fcheck = "no";
                            }
                          }else {
                            $fcheck = "no";
                          }
                        //  dd($check->fcount());
                        }
                          else {
                            $fcheck = "no";
                          }

              //  $data  = $count->count();
                $count = $count->count();
                if (!empty($count)) {
                    $count = count($count);
                  }
                  else {
                    $count = "";
                  }

      return view('follow-details', ['fcheck' => $fcheck,'posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count, 'following' => $following, 'follower' => $follower]);
    }
}
