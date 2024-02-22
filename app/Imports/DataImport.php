<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            foreach ($value as $item) {
                $item = \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($item) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item) : $item;
            } 
        }
        return $collection;
    }
}
