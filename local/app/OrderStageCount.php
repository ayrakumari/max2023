<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStageCount extends Model
{
  protected $table = 'order_stages_count';
  protected $guarded = [''];
  public $timestamps = false;
}
