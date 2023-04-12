<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OStageStep extends Model
{
  protected $table = 'order_statge_by_ordertype';
  protected $guarded = [''];
  public $timestamps = false;
}
