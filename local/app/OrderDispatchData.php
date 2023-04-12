<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDispatchData extends Model
{
  protected $table = 'order_dispatch_data';
  protected $guarded = [''];
  public $timestamps = false;
}
