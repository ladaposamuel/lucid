<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class ext_rss extends Model
{
  protected $fillable = [
    'user_id', 'title', 'url','description','image','link','lastBuildDate'
  ];
}
