<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStockIssue extends Model
{
  protected $table = 'item_stock_issue';
  protected $guarded = [''];
  public $timestamps = false;
}
