<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exports\MovieExport;
use Maatwebsite\Excel\Facades\Excel;



class ExcelController extends Controller
{

    public function export()
    {

        return Excel::download(new MovieExport, 'movies-2019.xlsx');

    }


}
