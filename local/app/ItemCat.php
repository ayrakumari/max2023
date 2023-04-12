<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCat extends Model
{
  protected $table = 'item_category';
  protected $guarded = [''];
  public $timestamps = false;
}
