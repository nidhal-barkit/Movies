<?php

namespace App\Exports;

use App\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;

class MovieExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $movie = Movie::join('users','users.id','=','movies.user_id')->select('year','title','users.name')->get();
        return $movie;
    }
}
