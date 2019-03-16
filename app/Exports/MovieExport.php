<?php

namespace App\Exports;

use App\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MovieExport implements FromCollection , WithHeadings ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'title',
            'year',
            'user_id',
            'published',
            'image',
        ];
    }
    public function collection()
    {
        $movie = Movie::select('title','year','user_id','published','image')->get();
        return $movie;

    }
}
