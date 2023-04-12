<?php

namespace App\Imports;

use App\RawClientData;
use App\Client;
use App\Sample;
use App\Item;
use App\ItemStock;
use App\ItemCat;
use Auth;


use Maatwebsite\Excel\Concerns\ToModel;

class ItemImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    

    public function model(array $row)
    {


         
        
         $itemcheck=RawClientData::where('product',$row[0])->where('company_name',$row[1])->where('contact_no',$row[3])->first();
         if($itemcheck==null){
            return new RawClientData([
                'product'     => $row[0],
                'company_name'     => $row[1],
                'location'     => $row[2],
                'contact_no'     => trim($row[3]),
                'website'     => $row[4],
                'application'     => $row[5],
                'source'     => $row[6]
     
             ]);
         }
         

        





       

      
    }
}
