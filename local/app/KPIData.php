<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class KPIData extends Model {

    protected $table = 'kpi_data';
    protected $guarded = [''];
    public $timestamps = false;
}
