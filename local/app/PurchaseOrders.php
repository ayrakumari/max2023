<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
  protected $table = 'purchase_orders';
  protected $guarded = [''];
  public $timestamps = false;
}
