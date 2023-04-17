<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBrand extends Model
{
  protected $table = 'clients_brands';
  protected $guarded = [''];
  public $timestamps = false;
}
