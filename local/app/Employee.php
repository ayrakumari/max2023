<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $table = 'hrm_emp';
  protected $guarded = [''];
  public $timestamps = false;
}
