<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QC_BOM_PurchaseLog extends Model
{
  protected $table = 'qc_bo_purchaselist_logs';
  protected $guarded = [''];
  public $timestamps = false;
}
