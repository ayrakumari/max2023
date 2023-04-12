<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
  protected $table = 'order_master';
  protected $guarded = [''];
  public $timestamps = false;
}
