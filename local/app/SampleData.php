<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleData extends Model
{
  protected $table = 'samples_xls_format';
  protected $guarded = [''];
  public $timestamps = false;
}
