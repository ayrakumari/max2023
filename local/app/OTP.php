<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
  protected $table = 'users_otp';
  protected $guarded = [''];
  public $timestamps = false;
}
