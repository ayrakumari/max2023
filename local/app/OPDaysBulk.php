<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPDaysBulk extends Model
{
  protected $table = 'order_process_days_bulk';
  protected $guarded = [''];
  public $timestamps = false;
}
