<?php

namespace App\Exports;

use App\Models\Hocol;
use Maatwebsite\Excel\Concerns\FromCollection;

class HocolExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Hocol::all();
    }
}
