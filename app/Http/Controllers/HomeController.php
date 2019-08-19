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
           $fcount =$sub->myfollowercount();
           $count = $sub->count();
           //dd($fcount);
           if (!empty($fcount)) {
               $fcount = count($fcount);
             }else {
               $fcount = "";
             }
             if (!empty($count)) {
               $count = count($count);
             }else {
               $count = "";
             }


             //User Follower checker
             if(Auth::user()){
               $check = new \Lucid\Core\Subscribe(Auth::user()->username);
               $fcheck = $check->followCheck($user->name);
             }
             else {
               $fcheck = "no";
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

      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount =$sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
          $fcount = count($fcount);
        }else {
          $fcount = "";
        }
        if (!empty($count)) {
          $count = count($count);
        }else {
          $count = "";
        }


        //User Follower checker
        if(Auth::user()){
          $check = new \Lucid\Core\Subscribe(Auth::user()->username);
          $fcheck = $check->followCheck($user->name);
        }
        else {
          $fcheck = "no";
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
      $request->validate([
        'body'=>'required'
      ]);

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
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount =$sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
          $fcount = count($fcount);
        }else {
          $fcount = "";
        }
        if (!empty($count)) {
          $count = count($count);
        }else {
          $count = "";
        }


        //User Follower checker
        if(Auth::user()){
          $check = new \Lucid\Core\Subscribe(Auth::user()->username);
          $fcheck = $check->followCheck($user->name);
        }
        else {
          $fcheck = "no";
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
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount =$sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
          $fcount = count($fcount);
        }else {
          $fcount = "";
        }
        if (!empty($count)) {
          $count = count($count);
        }else {
          $count = "";
        }


        //User Follower checker
        if(Auth::user()){
          $check = new \Lucid\Core\Subscribe(Auth::user()->username);
          $fcheck = $check->followCheck($user->name);
        }
        else {
          $fcheck = "no";
        }

      return view('settings', ['fcheck' => $fcheck,'user'=>$user,'fcount' => $fcount , 'count' => $count ]);

    }

    public function saveSettings(Request $request) {
          $validator=Validator::make($request->all(),[
            'name' => 'required',
            'email' => ['required','email',
             Rule::unique('users')->ignore(Auth::user()->id),
            ],
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' =>'required',
            'username'=>['required',
             Rule::unique('users')->ignore(Auth::user()->id),
            ]
        ]);

      if($validator->fails()){
          return response()->json($validator->messages(), 200);
      }
        $renamedUserContentFolder = false;
        if(Auth::user()->username !== $request->username){
          $oldUserPostFolderName = storage_path('app/'.Auth::user()->username);
          $oldUserImgFolderName = storage_path('app/public/'.Auth::user()->username);

          $newUserPostFolderName = storage_path('app/'.$request->username);
          $newUserImgFolderName = storage_path('app/public/'.$request->username);

        if(rename($oldUserPostFolderName, $newUserPostFolderName) && rename($oldUserImgFolderName, $newUserImgFolderName)){
            $renamedUserContentFolder = $request->username;
          }else{
            $renamedUserContentFolder = false;
          }
      }

      if(!empty($request->file('profileimage'))){
          $url = Auth::user()->username."/images/";
          if($renamedUserContentFolder !== false){
            $url = $renamedUserContentFolder."/images/";
          }

         $path = Storage::disk('public')->put($url, $request->file('profileimage'));
         $fullPath = '/storage/'.$path;
         $updated= DB::table('users')->where('id',$request->user_id)
                                    ->update(['name'=>$request->name,'username'=>$request->username,'email'=>$request->email,'image'=>$fullPath,
                                    'short_bio'=>$request->bio]);

        if($updated) {

          return response()->json(['success'=>"Your changes has been saved successfully",'img_path'=>$fullPath,'renamedUserContentFolderName'=>$renamedUserContentFolder], 200);
        }
      } else {

        $fullPath = Auth::user()->image;
        if($renamedUserContentFolder !== false){
          $pathArr = explode('/',$fullPath);
          $fullPath = '/storage/'.$renamedUserContentFolder.'/images//'.end($pathArr);
        }

        $updated = DB::table('users')->where('id',$request->user_id)
                                    ->update(['name'=>$request->name,'username'=>$request->username,'email'=>$request->email,'image'=>$fullPath,'short_bio'=>$request->bio]);

                                      if($updated){
                                        return response()->json(['success'=>"Your changes has been saved successfully",'renamedUserContentFolderName'=>$renamedUserContentFolder], 200);
                                      }
      }

    }

    public function updateContactDetails(Request $request){
        $validator=Validator::make($request->all(),[
          'email' => ['required','email',
            Rule::unique('contact_settings')->ignore(Auth::user()->id,'user_id'),
          ],
          'user_id'=>'required'

      ]);

      if($validator->fails()){
        return response()->json($validator->messages(), 200);
      }

      $detailsExist = DB::table('contact_settings')->where('user_id',$request->user_id)->first();

      if(empty($detailsExist)){
        $insert = DB::table('contact_settings')->insert([
          'user_id'=>$request->user_id,
          'email'=>$request->email,
          'display_message'=>$request->message
        ]);

        if($insert) {
          return response()->json(['success'=>'Your changes has been saved successfully'], 200);
        }


      }else{
        $update = DB::table('contact_settings')->where('user_id',$request->user_id)->update([
          'email'=>$request->email,
          'display_message'=>$request->message
        ]);

        if($update) {
          return response()->json(['success'=>'Your changes has been saved successfully'], 200);
        }else{
          return response()->json(['noChanges'=>'You made no changes'], 200);
        }
      }

    }

}
