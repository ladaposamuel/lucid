<?php
defined('ZIKI') or die('Direct access not permitted!');
date_default_timezone_set("Africa/Lagos");
// Autoloading.
require ZIKI_BASE_PATH .'/vendor/autoload.php';

$logger = new Monolog\Logger('Ziki');
$logger->pushHandler(new Monolog\Handler\StreamHandler( ZIKI_BASE_PATH . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'ziki.log'));
Monolog\ErrorHandler::register($logger);

$ziki = new App\Foundation(ZIKI_BASE_PATH);

return $ziki;
