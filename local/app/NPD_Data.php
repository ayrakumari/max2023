<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NPD_Data extends Model
{
  protected $table = 'rnd_new_product_development';
  protected $guarded = [''];
  public $timestamps = false;
}
