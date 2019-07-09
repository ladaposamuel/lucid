<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class user_settings extends Model
{
  /**
 * The table associated with the model.
 *
 * @var string
 */
protected $fillable = [
  'user_id', 'user_path', 'setting_path'
];
}
