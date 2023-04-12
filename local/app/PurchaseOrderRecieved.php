<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderRecieved extends Model
{
  protected $table = 'purchase_order_recieved';
  protected $guarded = [''];
  public $timestamps = false;
}
