<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('home', ['fcheck' => $fcheck, 'posts' => $feed,'fcount'=>$fcount, 'count' => $count]);

    }
    public function timeline($username)
    {
      $user = Auth::user();
      if ($username == $user->username) {

      $username = $user->username;
      $post = new \Lucid\Core\Document($username);

      $post = $post->fetchAllRss();

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
     return view('timeline', ['posts' => $post,'fcheck' => $fcheck, 'user'=>$user,'fcount'=>$fcount, 'count' => $count]);
     }else {

        return view($user->username.'/timeline', ['posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }
  }


/*
*
*
*

*/



    public function savePost(Request $request)
    {


      $title = '';
      $body = $request->body;
      // filter out non-image data

      $images = "";

      $extra = "";
      $user = Auth::user();
      $username = $user->username;
      $post = new \Lucid\Core\Document($username);
      $result = $post->create($title, $body, $tag="", $images, $extra, $postType="micro-blog");
      return redirect($username.'/thoughts')->with('msg', 'Post Published');
    }

    public function subscribe()
    {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];

      $post=[];
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
      return view('subscribe', ['fcheck' => $fcheck,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

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
        $result = $app->create($title, $body, $tags, $images, $extra, $postType="full-blog");
        return json_encode($result);
    }

    public function settings(){
      $user = Auth::user();
      $username = $user['username'];
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
      return view('settings', ['fcheck' => $fcheck,'user'=>$user,'fcount' => $fcount , 'count' => $count ]);

    }

    public function saveSettings(Request $request) {
          $validator=Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' =>'required'
        ]);

      if($validator->fails()){
          return response()->json($validator->messages(), 200);
      }

      if(!empty($request->file('profileimage'))){
         $url = Auth::user()->username."/images/";
         $path = Storage::disk('public')->put($url, $request->file('profileimage'));
         $fullPath = '/storage/'.$path;
         $updated= DB::table('users')->where('id',$request->user_id)
                           ->update(['name'=>$request->name,'email'=>$request->email,'image'=>$fullPath,
                           'short_bio'=>$request->bio]);

        if($updated) {

          return response()->json(['success'=>"Your changes has been saved successfully",'img_path'=>$fullPath], 200);
        }
      } else {
        $updated = DB::table('users')->where('id',$request->user_id)
                          ->update(['name'=>$request->name,'email'=>$request->email,'short_bio'=>$request->bio]);

                          if($updated){
                            return response()->json(['success'=>"Your changes has been saved successfully"], 200);
                          }
      }


    }

}
