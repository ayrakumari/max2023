<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItemGroup extends Model
{
  protected $table = 'purchased_items_group';
  protected $guarded = [''];
  public $timestamps = false;
}
