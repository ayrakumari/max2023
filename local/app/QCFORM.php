<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QCFORM extends Model
{
  protected $table = 'qc_forms';
  protected $guarded = [''];
  public $timestamps = false;
}
