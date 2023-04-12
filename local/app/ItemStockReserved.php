<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStockReserved extends Model
{
  protected $table = 'item_stock_reserved';
  protected $guarded = [''];
  public $timestamps = false;
}
