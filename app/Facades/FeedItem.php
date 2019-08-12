<?php
namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;
use \DateTime;


class FeedItem extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Document';
}
}
