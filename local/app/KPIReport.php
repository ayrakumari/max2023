<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class KPIReport extends Model {

    protected $table = 'kpi_report';
    protected $guarded = [''];
    public $timestamps = false;
}
