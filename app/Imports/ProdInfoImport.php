<?php

namespace App\Imports;

use App\Models\ProdInfo;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdInfoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProdInfo([
            'reference' => $row[0],
            'management_type' => $row[1],
            'description' => $row[2],
            'principal_image' => $row[3],
        ]);
    }
}
