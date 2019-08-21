<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Lucid\Mail\SendMail;
use Validator;
use DB;
class SendEmailController extends Controller
{
    public function sendEmail(Request $request,$username){

        $user_exists = DB::table('users')->where('name',$username)->orWhere('username',$username)->get();
        if(!isset($user_exists[0])) {
            return '===404===';
        }
        $user_email = DB::table('contact_settings')->where('user_id',$user_exists[0]->id)->first();

        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'message'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 200);
        }

        $data = [
            'name' =>$request->name,
            'email'=>$request->email,
            'message'=>$request->message
        ];

        if(!empty($user_email->email)){
            Mail::to($user_email->email)->send(new SendMail($data));
        }else{
            Mail::to($user_exists[0]->email)->send(new SendMail($data));
        }
        

        return response()->json(['success'=>'Thanks For The Feed Back! '],200);
    }
}
