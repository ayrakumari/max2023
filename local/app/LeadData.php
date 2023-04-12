<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadData extends Model
{
  protected $table = 'indmt_data';
  protected $guarded = [''];
  public $timestamps = true;
}
