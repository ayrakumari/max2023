<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class UserAccess extends Model
{
  protected $table = 'users_access';
  protected $guarded = [''];
  public $timestamps = false;
}
