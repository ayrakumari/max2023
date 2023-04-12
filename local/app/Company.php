<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Company extends Model {

    protected $table = 'client_company';
    protected $fillable = [
        'user_id',
        'user_role',
        'company_name',
        'brand_name',
        'gst_details',
        'address',
        'sale_agent_id',
        'remarks'
    ];
        public $timestamps = false;
}
