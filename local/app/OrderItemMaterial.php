<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemMaterial extends Model
{
  protected $table = 'orders_items_material';
  protected $guarded = [''];
  public $timestamps = false;
}
