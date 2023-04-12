<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class RowClient extends Model {

    protected $table = 'client_raws';
    protected $guarded = [''];
    public $timestamps = false;
}
