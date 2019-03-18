<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Movie;

class PhpSpreedSheetController extends Controller
{
    public function  export()
    {
        $spreadsheet = new Spreadsheet();  /*----Spreadsheet object-----*/
        $Excel_writer = new Xlsx($spreadsheet);
        /*----- Excel (Xls) Object*/

        $filename = "movies";

        $rows = 2;
        $types = Type::all();

        foreach($types as $t){


            $spreadsheet->createSheet();
            // Create a new worksheet called "My Data"
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $t->type);
            // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
            $spreadsheet->addSheet($myWorkSheet, 0);

            $movies = Movie::join('movie_types','movie_types.movie_id','=','movies.id')
                ->join('types','types.id','=','movie_types.type_id')
                ->where('types.id','=',$t->id)->select('movies.*')->get();

            foreach($movies as $movie) {

                $spreadsheet->setActiveSheetIndex(0);
                $activeSheet = $spreadsheet->getActiveSheet();
                $rowss = 2;

                $activeSheet->setCellValue('A1', 'Titre');
                $activeSheet->setCellValue('B1', 'Année');
                $activeSheet->setCellValue('C1', 'Auteur');
                $activeSheet->setCellValue('D1', 'Publiée');
                $activeSheet->setCellValue('E1', 'Image');



                $activeSheet->setCellValue('A'.$rowss, $movie['title']);
                $activeSheet->setCellValue('B'.$rowss, $movie['year']);
                $activeSheet->setCellValue('C'.$rowss, $movie['user_id']);
                $activeSheet->setCellValue('D'.$rowss, $movie['published']);
                $activeSheet->setCellValue('E'.$rowss, $movie['image']);

            }
            $rows++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.Xlsx"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        $Excel_writer->save('php://output');

    }
}
