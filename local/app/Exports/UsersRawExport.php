<?php

namespace App\Exports;

use App\RawClientDataSample;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersRawExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RawClientDataSample::all();
    }
}
