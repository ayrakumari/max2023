<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
  protected $table = 'client_notes';
  protected $guarded = [''];
  public $timestamps = true;
}
