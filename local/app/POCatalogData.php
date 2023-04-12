<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POCatalogData extends Model
{
  protected $table = 'packaging_options_catalog';
  protected $guarded = [''];
  public $timestamps = false;
}
