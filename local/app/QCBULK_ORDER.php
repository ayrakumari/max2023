<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QCBULK_ORDER extends Model
{
  protected $table = 'qc_bulk_order_form';
  protected $guarded = [''];
  public $timestamps = false;
}
