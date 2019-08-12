<?php

namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;

use Lucid\Core\FileSystem;
use PHPMailer\PHPMailer\PHPMailer;

class Auth  extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Auth';
}
}
