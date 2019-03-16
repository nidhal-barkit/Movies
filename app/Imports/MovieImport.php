<?php

namespace App\Imports;

use App\Movie;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MovieImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Movie([
            'title'     => $row['title'],
            'year'      => $row['year'],
            'user_id'   => $row['user_id'],
            'published' => $row['published'],
            'image'     => '',
        ]);

    }
}
