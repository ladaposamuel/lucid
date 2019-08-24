<?php

namespace Lucid\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Lucid\Http\Controllers\Controller;
use Lucid\user_settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function store(Request $request)
   {
      // Validate the request...

      $Setting = new user_settings();

      $Setting->user_id = $request->user_id;
      $Setting->user_path = $request->user_path;
      $Setting->setting_path = $request->setting_path;

      $Setting->save();
      // return ;
   }


   public function settings()
   {
      $user = Auth::user();
      $username = $user['username'];
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

      return view('settings', ['fcheck' => $fcheck, 'user' => $user, 'fcount' => $fcount, 'count' => $count]);

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
      $validator= Validator::make($request->all(),[
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
