<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QCPurchaseEditHistory extends Model
{
  protected $table = 'qc_bo_purchaselist_edit_history';
  protected $guarded = [''];
  public $timestamps = false;
}
