<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawClientData extends Model
{
  protected $table = 'raw_client_data';
  protected $guarded = [''];
  public $timestamps = false;
}
