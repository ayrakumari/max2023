<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawClientDataSampleAttendance extends Model
{
  protected $table = 'emp_attendance';
  protected $guarded = [''];
  public $timestamps = false;
}
