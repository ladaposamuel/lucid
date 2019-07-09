<?php
namespace Lucid\Core;
use Lucid\Core\FileSystem;

class Profile {


        private function filterString($string)
        {
            $string=htmlspecialchars($string);
            $string=strip_tags($string);
            $string = stripslashes($string);

            return $string;
        }

    public function updateProfile($request){
        //check if the name is not empty.
       
        $results=[];
        if(empty(trim($request['name'])))
        {
            $results['Error'] = 'This is a required field';
            
        }
        else
        {
            $name = $this->filterString($request['name']);
        }
        
        //checks if email is not empty
        if(empty(trim($request['new_email'])))
        {
            $results['Error'] = 'This is a required field';
            
        }
        else
        {
            if(filter_var($request['new_email'],FILTER_VALIDATE_EMAIL) === false)
            {
                $results['Error'] = 'Please input a valid email address';
                
                //$email = $request['email'];
            }
            else
            {
                $old_email= $this->filterString($request['old_email']);
                $new_email = $this->filterString($request['new_email']);
            }
        }
            // Get Image Dimension
            $fileinfo = getimagesize($_FILES["image"]["tmp_name"]);
            
            
            $allowed_image_extension = array(
                "png",
                "jpg",
                "jpeg"
            );
            
            // Get image file extension
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            
            // Validate file input to check if is not empty
            if (! file_exists($_FILES["image"]["tmp_name"])) {
                $target = "";
            
            }   
             // Validate file input to check if is with valid extension
            else if (! in_array($file_extension, $allowed_image_extension)) {
                $results['Error']  =  "Upload valid images. Only PNG, JPG and JPEG are allowed.";
                
            
            }    // Validate image file size
            else if (($_FILES["image"]["size"] > 1000000)) {
                $results['Error']  = "Image size exceeds 1MB";
                
                
            }    // Validate image file dimension
            else {
                if (is_dir('./storage/user/')) {
                    $handle = opendir('./storage/user/');
                    while (false !== ($entry = readdir($handle))) {
                        unlink('./storage/user/'.$entry);
                    }
                }
                else{
                    $url = "./storage/user/";
                    FileSystem::makeDir($url);
                }
                 $target =  './storage/user/user.'.$file_extension;
                 if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target)){
                     $results['Error'] = "problem occured when uploading images";
                     
                 } 
            } 
                //check if error messages are not fixed before saving
                if($results['Error'] == "" ){
                // make curl call if image upload is successful
                $url = "https://auth.techteel.com/api/update_email?old_email={$old_email}&new_email={$new_email}";
                $ch = curl_init();
                //Set the URL that you want to GET by using the CURLOPT_URL option.
                curl_setopt($ch, CURLOPT_URL, $url);
                
                //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                
                //Execute the request.
                $result = curl_exec($ch);
                
                //Close the cURL handle.
                curl_close($ch);
                $res = json_decode($result);
                //Save User data to auth.json
                $dir = "./src/config/auth.json";
                $check_settings = FileSystem::read($dir);
                $check_prev = json_decode($check_settings);
                //update email
                $check_prev->email = $res->email;
                //update name
                $fullname = explode(" ", $name);
                $check_prev->firstname = $fullname[0];
                $check_prev->lastname = $fullname[1];
                //update bio
                  //check if bio aint empty
        if(!empty(trim($request['bio'])))
        {
            $bio = $this->filterString($request['bio']);
        }
      
                $check_prev->siteTagline = $bio;
                //update image
                if($target != ""){
                $check_prev->image = $target;
                }
                //write back the updated result
                $data = json_encode($check_prev);
                $json_user = FileSystem::write($dir, $data);
                if($json_user){
                    $result = $check_prev;
                    $results['Success'] = "profile detail updated succesfully"; 
                }
                else{
                    $result = array("error" => true, "message" => "error while updatng auth.json");
                }
                //return $result; 
                } 
                else {
                    $results['MainError']  = "Problem in updating profile, please try again.";
                    
                }
            
            
     return $results;
       
    }
}


     


    
