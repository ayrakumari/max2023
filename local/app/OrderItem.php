<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  protected $table = 'orders_req_items';
  protected $guarded = [''];
  public $timestamps = false;
}
