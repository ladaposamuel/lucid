<?php
namespace Lucid\Facades;
use Illuminate\Support\Facades\Facade;

class Config  extends Facade
{
  protected static function getFacadeAccessor()
{
    return 'Config';
}
}
