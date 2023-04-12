<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStockEntry extends Model
{
  protected $table = 'item_stock_entry';
  protected $guarded = [''];
  public $timestamps = false;
}
