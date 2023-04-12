<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
  protected $table = 'items_master';
  protected $guarded = [''];
  public $timestamps = false;
}
