<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QC_BOM_Purchase extends Model
{
  protected $table = 'qc_bo_purchaselist';
  protected $guarded = [''];
  public $timestamps = false;
}
