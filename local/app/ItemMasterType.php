<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMasterType extends Model
{
  protected $table = 'items_master_type';
  protected $guarded = [''];
  public $timestamps = false;
}
