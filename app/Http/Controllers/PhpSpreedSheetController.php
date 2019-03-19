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
        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);

        $filename = "movies";
        $types = Type::all();

        foreach($types as $t){

            $spreadsheet->createSheet();
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $t->type);
            $spreadsheet->addSheet($myWorkSheet, 0);

            $movies = Movie::join('movie_types','movie_types.movie_id','=','movies.id')
                ->join('types','types.id','=','movie_types.type_id')
                ->where('types.id','=',$t->id)->select('movies.*')
                ->get();
            $styleArray = array(
                'borders' => array(
                    'outline' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            );
            $row = 2;
            foreach($movies as $movie) {

                $spreadsheet->setActiveSheetIndex(0);
                $activeSheet = $spreadsheet->getActiveSheet();

                $activeSheet->setCellValue('A1', 'Titre')->getStyle('A1')->applyFromArray($styleArray);
                $activeSheet->setCellValue('B1', 'Année');
                $activeSheet->setCellValue('C1', 'Auteur');
                $activeSheet->setCellValue('D1', 'Publiée');
                $activeSheet->setCellValue('E1', 'Image');

                $activeSheet->setCellValue('A'.$row, $movie['title']);
                $activeSheet->setCellValue('B'.$row, $movie['year']);
                $activeSheet->setCellValue('C'.$row, $movie['user_id']);
                $activeSheet->setCellValue('D'.$row, $movie['published']);
                $activeSheet->setCellValue('E'.$row, $movie['image']);
                $row++;
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.Xlsx"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        $Excel_writer->save('php://output');

    }

    public function import(Request $request){

        $inputFileName = $request->get('file');

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        return redirect('/movies');

    }
}
