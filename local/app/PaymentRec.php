<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PaymentRec extends Model {

    protected $table = 'payment_recieved_from_client';
    protected $guarded = [''];
    public $timestamps = false;
}
