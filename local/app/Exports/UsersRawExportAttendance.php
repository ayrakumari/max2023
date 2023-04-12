<?php

namespace App\Exports;

use App\RawClientDataSampleAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersRawExportAttendance implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RawClientDataSampleAttendance::all();
    }
}
