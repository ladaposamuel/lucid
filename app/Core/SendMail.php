<?php 
//namespace Lucid\Core;

include ZIKI_BASE_PATH."/src/mailer/PHPMailerAutoload.php";

//use Lucid\Core\filesystem as FileSystem;

class SendContactMail{
    
    public $guestName;
    public $guestEmail;
    public $guestMsg;
    public $mailBody;
    public $error=[];
    public $successMsg=[];
    public $about;
    public $ownerMail;
    public $guestSubject;

    public function __construct()
    {
        $this->ownerMail = $this->getOwnerEmail();
    }

    public function sendMail($request)
    {
        if(empty(trim($request['guestName'])))
        {
            $this->error['nameError']="This is a required field";
        }
        else
        {
            $this->guestName=$this->filterString($request['guestName']);
        }

        if(empty(trim($request['guestEmail'])))
        {
            $this->error['emailError']= 'This is a required field';
        }
        else
        {
            if(filter_var($request['guestEmail'],FILTER_VALIDATE_EMAIL) === false)
            {
                $this->error['emailError'] = 'Please input a valid email address';
                $this->guestEmail = $request['guestEmail'];
            }
            else
            {
                $this->guestEmail=$this->filterString($request['guestEmail']);
            }
        }

        if(empty(trim($request['guestSubject'])))
        {
            $this->error['subjectError']= 'This is a required field';
        }
        else
        {
            $this->guestSubject = $this->filterString($request['guestSubject']);
        }

        if(empty(trim($request['guestMsg'])))
        {
            $this->error['msgError']= 'This is a required field';
        }
        else
        {
            $this->guestMsg = $this->filterString($request['guestMsg']);
        }

        if(empty($this->error))
        {
            
                if($this->sendMailToOwner())
                {
                    $this->successMsg['success']='Thanks for sending your feedback,i hope to reply  soon!';
                    return $this->successMsg;
                }
                else
                {
                    $this->error['serverError'] = 'FeedBack could not be sent, please make sure you have an active internet  connection!';
                    return $this->error;
                }
            
        }
        else
        {
            $this->error['FormFieldError']='Please Fix The Errors On The Input Fields To Send Your FeedBack!';
            return $this->error;
        }
    }


    private function filterString($string)
    {
        $string=htmlspecialchars($string);
        $string=strip_tags($string);
        $string = stripslashes($string);

        return $string;
    }

    private function sendMailToOwner()
    {
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 4;                                  // Enable verbose debug output
        $mail->isSMTP();  
                                                             // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'zikihnginternssmtp@gmail.com';                             // SMTP username
        $mail->Password = 'zikiinterns';                              // SMTP password
        $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                  // TCP port to connect to

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
            );
        $mail->setFrom($this->guestEmail,'CONTACT FORM: '.$this->guestName);
        $mail->addAddress($this->ownerMail);                   // Name is optional
        $mail->addReplyTo($this->guestEmail, $this->guestName);
            
        $mail->isHTML(true);                

        $mail->Subject = $this->guestSubject;
        $mail->Body    = $this->mailBody;
        $mail->AltBody = $this->guestMsg;

        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function redirect($location)
    {
        header('Location:'.$location);
    }


    public function clientMessage()
    {
         $inputdata = ['name'=>$this->guestName,'email'=>$this->guestEmail,'msg'=>$this->guestMsg,'subject'=>$this->guestSubject];
        if(!empty($this->error))
        {
            $_SESSION['messages']=$this->error;
            foreach($inputdata as $key =>$value)
            {
                $_SESSION['messages'][$key]=$value;
            }
        }
        elseif(!empty($this->successMsg))
        {
            $_SESSION['messages']=$this->successMsg;
        }
    }

    public function getOwnerEmail()
    {
        $dir = "./src/config/auth.json";

        $app_json ="./src/config/app.json";
        $getContent = [];
        if(file_exists($app_json))
        {
            $getContent = json_decode(file_get_contents($app_json),true);
        }
        

        if(isset($getContent['CONTACT_EMAIL']) && !empty($getContent['CONTACT_EMAIL']))
        {
            return $getContent['CONTACT_EMAIL'];
        }
        else
        {
            if(file_exists($dir))
            {
                $getOwnerEmail = file_get_contents($dir);
                if($getOwnerEmail)
                {
                    $getOwnerEmail = json_decode($getOwnerEmail,true);
                    return $getOwnerEmail['email'];
                }
            }
        }
    }

    public function setContactEmail($request)
    {
        if(empty(trim($request['contactEMail'])))
        {
            $this->error['emailError'] = "Please set your contact email";
        }
        else
        {
            if(filter_var($request['contactEMail'],FILTER_VALIDATE_EMAIL) === false)
            {
                $this->error['emailError'] = 'Please input a valid email address';
                $this->guestEmail = $request['contactEMail'];
            }
            else
            {
                $this->guestEmail=$this->filterString($request['contactEMail']);
            }
        }

        if(empty($this->error))
        {
            $app_json ="./src/config/app.json";
            //$fopen = fopen($app_json,'w');
            $getContent = json_decode(file_get_contents($app_json),true);
            if(isset($getContent['CONTACT_EMAIL']))
            {
                $getContent['CONTACT_EMAIL'] = $this->guestEmail;
            }
            else
            {
                $getContent['CONTACT_EMAIL'] = $this->guestEmail;
            }

            if(file_put_contents($app_json,json_encode($getContent)))
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
            $this->error['FormFieldError']='Your changes could not be saved due to the errors below!';
            return $this->error;
        }
    }

    public function getPage()
    {
        $page = './storage/page/about.md';
        if(file_exists($page))
        {
            return file_get_contents($page);
        }
    }
}

