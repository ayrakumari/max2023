<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ContactClient extends Model {

    protected $table = 'users_contact';
    protected $guarded = [''];
    public $timestamps = false;
}
