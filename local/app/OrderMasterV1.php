<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMasterV1 extends Model
{
  protected $table = 'st_process_action';
  protected $guarded = [''];
  public $timestamps = false;
}
