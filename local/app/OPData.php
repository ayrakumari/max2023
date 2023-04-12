<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPData extends Model
{
  protected $table = 'order_process_data';
  protected $guarded = [''];
  public $timestamps = false;
}
