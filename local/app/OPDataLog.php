<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPDataLog extends Model
{
  protected $table = 'order_process_data_logs';
  protected $guarded = [''];
  public $timestamps = false;
}
