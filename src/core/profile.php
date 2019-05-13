<?php

namespace Ziki\Core;

Class profileUpdate {

Public $fullName;
Public $shortBio;


Public function __construct ($fullName, $shortBio){
     $this->fullname =$fullName;
     $this->shortBio =$shortBio;

   }

// Public function profile_setter (){
//  //checking for POST
// if ($_SERVER ['REQUEST METHOD'] == 'POST'){
// //process form
// }
// Else {
// //init data
//    $data  =[
//         'fullName' => ' ',
//          'shortBio' =>' ',
//          'fullName_err' => ' ', //this is to check and make sure the page is not empty
//           'shortBio_err' => ' ' //same with this also
//         ];
// }
// //loading profile in view (mercy side it's sidebar and the last time I checked, I didn't see anything like that)

// $this->view('resource/theme/ghost/template/sidebar.html');
// }
        private function filterString($string)
        {
            $string=htmlspecialchars($string);
            $string=strip_tags($string);
            $string = stripslashes($string);

            return $string;
        }

    public function getUser(){
        $this->fullname;
        $this->shortbio;

        if(empty(trim($request['fullname'] && $request['shortbio'])))
        {
            $this->error['fullname'] = 'This field Shouldn\'t be empty';
            $this->error['shortbio'] = 'This field Shouldn\'t be empty';
        }
        else
        {
            $this->fullname = strip_tags($request['fullname']);
            $this->shortbio = strip_tags($request['shortbio']);
        }

        if(empty($this->error))
        {
            $dir = './storage/page/';
            if(file_exists($dir))
            {
                $page = $dir.'profileupdate.md';
                if(file_put_contents($page,$this->fullname, $this->shortbio))
                {
                    $this->successMsg['success']='Successfully saved';
                    return $this->successMsg;
                }
                else
                {
                    return $this->error['serverError'] = 'Settings could not be saved due technical issues! please try again later.';
                }
            }
            else
            {
                if(mkdir($dir))
                {
                    $page = $dir.'profileupdate.md';
                    if(file_put_contents($page,$this->fullname,$this->shortbio))
                    {
                        $this->successMsg['success']='Successfully saved';
                        return $this->successMsg;
                    }
                    else
                    {
                        return $this->error['serverError'] = 'Settings could not be saved due technical issues! please try again later.';
                    }
                }
            }
                
            
        }
        else
        {
            $this->error['FormFieldError']='Your changes could not be saved due to the errors below!';
            return $this->error;
        }
    }

    public function getPage()
    {
        $page = './storage/page/profileupdate.md';
        if(file_exists($page))
        {
            return file_get_contents($page);
        }
    }

    

    
}