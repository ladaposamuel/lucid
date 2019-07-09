<?php
namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;

use \DateTime;
use FeedItem as Item;


abstract class Feed extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Feed';
}
}
