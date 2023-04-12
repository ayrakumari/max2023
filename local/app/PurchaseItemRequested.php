<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItemRequested extends Model
{
  protected $table = 'purchased_items_request';
  protected $guarded = [''];
  public $timestamps = false;
}
