<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QC_ProductionLog extends Model
{
  protected $table = 'qc_bo_production_log';
  protected $guarded = [''];
  public $timestamps = false;
}
