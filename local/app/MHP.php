<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MHP extends Model
{
  protected $table = 'model_has_permissions';
  protected $guarded = [''];
  public $timestamps = false;
}
