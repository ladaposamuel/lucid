<?php
namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;

use Parsedown;
use Mni\FrontYAML\Parser;
use KzykHys\FrontMatter\FrontMatter;
use Symfony\Component\Finder\Finder;
use KzykHys\FrontMatter\Document as Doc;

/**
 *	The Document class holds all properties and methods of a single page document.
 *
 */

class Document extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Document';
}
}
