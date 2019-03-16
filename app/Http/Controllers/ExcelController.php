<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exports\MovieExport;
use App\Imports\MovieImport;
use Maatwebsite\Excel\Facades\Excel;
use Prologue\Alerts\Facades\Alert;



class ExcelController extends Controller
{

    public function export()
    {

        return Excel::download(new MovieExport, 'movies-2019.xlsx');

    }

    public function import()
    {
        Excel::import(new MovieImport,request()->file('file'));
        Alert::success('Importation avec succés')->flash();
        return back();
    }


}
