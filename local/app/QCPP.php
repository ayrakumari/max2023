<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QCPP extends Model
{
  protected $table = 'qc_forms_packing_process';
  protected $guarded = [''];
  public $timestamps = false;
}
