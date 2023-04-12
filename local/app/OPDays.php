<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPDays extends Model
{
  protected $table = 'order_process_days';
  protected $guarded = [''];
  public $timestamps = false;
}
