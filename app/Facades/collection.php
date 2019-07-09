<?php
namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;

/**
 *	A Collection object represents a set of Document objects (matching certain criterias).
 *
 */
class Collection  extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Collection';
}
}
