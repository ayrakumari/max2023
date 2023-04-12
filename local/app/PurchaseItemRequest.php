<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItemRequest extends Model
{
  protected $table = 'purchase_items_request';
  protected $guarded = [''];
  public $timestamps = false;
}
