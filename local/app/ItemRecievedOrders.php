<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRecievedOrders extends Model
{
  protected $table = 'items_recieved_orders';
  protected $guarded = [''];
  public $timestamps = false;
}
