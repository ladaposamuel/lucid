<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class ExtRss extends Model
{
  /**
 * The table associated with the model.
 *
 * @var string
 */
protected $fillable = [
  'user_id', 'title', 'url','description','image','link','lastBuildDate'
];
}
