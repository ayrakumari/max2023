<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
  protected $table = 'item_stock';
  protected $guarded = [''];
  public $timestamps = false;
}
