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

            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();

            $activeSheet->setCellValue('A1', 'Type');
            $activeSheet->setCellValue('B1', 'Created_at');
            $activeSheet->setCellValue('C1', 'Updated_at');

            $spreadsheet->createSheet();
            // Create a new worksheet called "My Data"
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $t->type);
            // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
            $spreadsheet->addSheet($myWorkSheet, 0);

            $activeSheet->setCellValue('A2', $t['type']);
            $activeSheet->setCellValue('B2', $t['created_at']);
            $activeSheet->setCellValue('C2', $t['updated_at']);

            $rows++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.Xlsx"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        $Excel_writer->save('php://output');

    }
}
