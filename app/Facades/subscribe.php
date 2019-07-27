<?php
namespace Lucid\Facades;
use Auth;
use Storage;
use Lucid\ext_rss;
use Illuminate\Support\Facades\Facade;
/**
 *
 */
class Subscribe extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Subscribe';
}
}
