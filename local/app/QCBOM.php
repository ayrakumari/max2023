<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QCBOM extends Model
{
  protected $table = 'qc_forms_bom';
  protected $guarded = [''];
  public $timestamps = false;
}
