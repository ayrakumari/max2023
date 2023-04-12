<?php

namespace App\Imports;

use App\RawClientData;
use App\QCFORM;
use App\Client;
use App\Sample;

use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    

    public function model(array $row)
    {

      $uname= 'O';     
      $num = $row[12];
      $str_length = 4;
      $sid_code = $uname."#".substr("0000{$num}", -$str_length); 


      //  return new QCFORM([
      //      'brand_name'     => $row[0],
      //      'order_repeat'     => $row[1]=='YES'? 1:1,
      //      'pre_order_id'     => $row[2],
      //      'item_name'     => $row[3],
      //      'item_size'     => $row[4],
      //      'item_size_unit'=> $row[5],
      //      'item_qty'=> $row[6],
      //      'item_qty_unit'=> $row[7],
      //      'item_fm_sample_no'=> $row[8],
      //      //'item_sp'=> $row[9],
      //      'created_by'     => $row[10],
      //      'order_type'     => $row[11],
      //     // 'due_date'     => $row[11],
      //      'order_index'     => $row[12],
      //      'order_id'     => $sid_code,
      //      'subOrder'     => $row[13],
      //      'yr'     => date('Y'),
      //      'mo'     => date('m')          

      //   ]);

        return new RawClientData([
           'product'     => $row[0],
           'company_name'     => $row[1],
           'location'     => $row[2],
           'contact_no'     => trim($row[3]),
           'website'     => $row[4],
           'application'     => $row[5],
           'source'     => $row[6]

        ]);





        //for client upload
        // return new Client([
        //    'company'     => $row[0],
        //    'brand'     => $row[1],
        //    'address'     => $row[2],
        //    'gstno'     => $row[3],
        //    'firstname'     => $row[4],
        //    'email'     => $row[5],
        //    'phone'     => $row[6],
        //    'added_by'     => $row[7]
        //
        //
        // ]);
    //  for client upload


      //for client sample
      // return new Sample([
      //    'sample_index'     => $row[0],
      //    'sample_code'     => $row[1],
      //    'client_id'     => $row[2],
      //    'courier_id'     => $row[3],
      //    'track_id'     => $row[4],
      //    'created_at'     => $row[5],
      //    'status'     => $row[6],
      //    'created_by'     => $row[7],
      //    'remarks'     => $row[8],
      //
      //    'ship_address'     => $row[9],
      //    'sample_details'     => $row[10],
      //
      //
      //
      // ]);
    //for client upload
    
    }
   

   
}
