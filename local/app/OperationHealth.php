<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationHealth extends Model
{
  protected $table = 'h_operation';
  protected $guarded = [''];
  public $timestamps = false;
}
