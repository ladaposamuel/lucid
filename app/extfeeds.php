<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class extfeeds extends Model
{

  /**
 * The table associated with the model.
 *
 * @var string
 */
  protected $fillable = [
    'user_id',
    'site',
    'site_image',
    'title',
    'des',
    'link',
    'date',
    'image'
  ];
}
