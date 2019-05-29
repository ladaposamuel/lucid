<?php

//API Details
$apiKey = '8ab8d82e751f0b8547bec1cdc328336e-us20';
$listId = '939e86e434';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    if($email) {
        //Create mailchimp API url
        $memberId = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        print $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

        //Member info
        $data = array(
            'email_address'=>$email,
            'status' => 'subscribed',
            );
        $jsonString = json_encode($data);

        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //Collecting the status
        switch ($httpCode) {
            case 200:
            $msg = 'You have succesfully submitted to the Ziki email list, we will keep you updated!';
                break;
            case 214:
            $msg = 'oops, You are already Subscribed';
                break;
            default:
            $msg = 'Oops, please try again.[msg_code='.$httpCode.']';
                break;
        }
    }

    header('location:mail.php');
}
