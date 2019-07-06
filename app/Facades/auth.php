<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

use App\Core\FileSystem;
use PHPMailer\PHPMailer\PHPMailer;

class Auth  extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Auth';
}
}
