<?php

namespace App\Imports;

use App\RawClientData;
use App\Client;
use App\Sample;
use App\QCFORM;

use Maatwebsite\Excel\Concerns\ToModel;

class OrderImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    

    public function model(array $row)
    {
        return new QCFORM([
           'order_id'     => $row[0],
           'brand_name'     => $row[1],
           'order_repeat'     => $row[2],
           'pre_order_id'     => trim($row[3]),
           'item_name'     => $row[4],
           'item_size'     => $row[5],
           'item_qty'     => $row[6],
           'item_fm_sample_no'=> $row[7]

        ]);   


     
    }
}
