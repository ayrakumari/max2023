<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPDaysRepeat extends Model
{
  protected $table = 'order_process_days_repeat';
  protected $guarded = [''];
  public $timestamps = false;
}
