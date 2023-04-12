<?php

namespace App\Exports;

use App\SampleData;
use Maatwebsite\Excel\Concerns\FromCollection;

class SampleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SampleData::all();
    }
}
