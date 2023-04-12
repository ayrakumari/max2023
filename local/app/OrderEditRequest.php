<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderEditRequest extends Model
{
  protected $table = 'order_edit_requests';
  protected $guarded = [''];
  public $timestamps = false;
}
