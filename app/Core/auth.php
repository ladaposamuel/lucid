<?php

namespace Lucid\Core;

use Lucid\Core\FileSystem;
use PHPMailer\PHPMailer\PHPMailer;
class Auth {
    /**
     * This function will get the auth details from specified url
     */
    public static function isInstalled()
    {
        $dir = "./src/config/auth.json";
        $check_settings = FileSystem::read($dir);
        if(!$check_settings) {
            $install = true;
        }
        else{
            $install = false;
        }
        return $install;
    }

    public static function sendMail($destination, $name, $address) {
         // Send success mail
         $mail = new PHPMailer;
         $mail->isSMTP();
         $mail->Host = "smtp.gmail.com";
         $mail->SMTPAuth = true;
         $mail->Username = "zikihnginternssmtp@gmail.com";
         $mail->Password = "zikiinterns";
         $mail->SMTPSecure = "tls";
         $mail->Port = 587;

         $mail->From = "zikihnginternssmtp@gmail.com";
         $mail->FromName = "Lucid";
         $mail->addAddress($destination, $name);
         $mail->isHTML(true);
         $variables = array();
         $variables['name'] = $name;
         $variables['address'] = $address;
         $variables['email-address'] = $destination;
         $email_temp = "./src/config/email.php";
         $template = file_get_contents($email_temp);
         foreach($variables as $key => $value) {
             $template = str_replace('{{ '.$key.' }}', $value, $template);
         }
         $mail->Subject = "Welcome To Lucid";
         $mail->Body = $template;

         if(!$mail->send())
         {
             return false;
         }
         else
         {
             return true;
         }
    }
    public static function setup ($data)
    {
        if($data['email'] =='' || $data['firstname'] =='' || $data['lastname'] =='' || $data['acceptTerms'] == '') {
            $failed = array('error' => true, 'message' => 'Compulsory fields are not filled [email, firstname, lastname, and terms].');
            die(json_encode($failed));
        }
        else{
            $check_settings = self::isInstalled();
            if($check_settings == true) {
                $s_file = "./src/config";
                $data['name'] = $data['firstname']." ".$data['lastname'];
                $site_url = $data['domainName'];
                $data['image'] = "https://res.cloudinary.com/dc9kfp5gt/image/upload/v1556862782/business-color_business-contact-86_icon-icons.com_53469_ckkqq7.png";
                $save = json_encode($data);
                $doc = FileSystem::write("{$s_file}/auth.json", $save);
                $destination = $data['email'];
                $mail_check = self::sendMail($destination, $data['name'], $site_url);

                /*$url = "https://auth.techteel.com/api/login/email?address={$data['email']}?domain={$site_url}";
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
                curl_close($ch);*/
                return $mail_check;
            }
            else{
                return false;
            }
        }
    }
    public static function getAuth($data, $role){
        $user['name'] = $data->name;
        $user['email'] = $data->email;
        $user['image'] = $data->image;
        $user['last_login'] = $data->updated_at;
        $user['role'] = $role;
        $user['login_token'] = md5($data->email);
        $_SESSION['login_user'] = $user;
        return true;
    }
    public function hash($data){
        $ch = curl_init();
        //Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, "https://auth.techteel.com/api/encrpt?host={$data}");

        //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        //Execute the request.
        $result = curl_exec($ch);

        //Close the cURL handle.
        curl_close($ch);
        return $result;
    }
    // Log in user check
    public function is_logged_in() {
        // Check if user session has been set
        // echo json_encode($_SESSION); -- it shows that the SESSION is empty because you login owner after install and you never setup session for them
        if (isset($_SESSION['login_user']) && ($_SESSION['login_user']['login_token'] != '')) {
            return $_SESSION;
        }
    }
    // session checks
    public function is_admin() {
        if ($_SESSION['login_user']['role'] == 'admin'){
            return true;
        }
        else{
            return false;
        }
    }
    // Log out user
    public function log_out() {
        // Destroy and unset active session
        session_destroy();
        unset($_SESSION);
        return true;
    }
    public function validateAuth($params) {
        $auth_response =  array();
        $data =  explode(",", $params);
        $provider = $data[0];
        $token = $data[1];
        $ch = curl_init();
        //Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($ch, CURLOPT_URL, "https://auth.techteel.com/api/authcheck/{$provider}/{$token}");

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
        if(!$check_settings) {
            $json_user = FileSystem::write($dir, $result);
            if($json_user){
                $role = "admin";
                $auth =self::getAuth($res, $role);
                $auth_response = $auth;
            }
        }
        else{
            $check_prev = json_decode($check_settings);
            if($check_prev->email == $res->email){
                $role = "admin";
                $auth = self::getAuth($check_prev, $role);
                $auth_response = $auth;
            }
            else{
                $role = "guest";
                $auth =self::getAuth($res, $role);
                $auth_response = $auth;
            }
        }
        return $auth_response;
    }
    public function redirect($location)
    {
        header('Location:'.$location);
    }
}
