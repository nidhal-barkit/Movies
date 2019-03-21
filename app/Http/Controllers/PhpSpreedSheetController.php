<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Movie;
use Prologue\Alerts\Facades\Alert;

class PhpSpreedSheetController extends Controller
{
    public function  export()
    {
        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);

        $filename = "movies";
        $types = Type::all();

        foreach($types as $t){


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

        $inputFileName = $request->file('file');

        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spread = $reader->load($inputFileName);
        $Excel_writer = new Xlsx($spread);

        $save_path = public_path("imports");
        if (! file_exists($save_path) && ! mkdir($save_path, 0777, true) && ! is_dir($save_path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $save_path));
        }
        $id = uniqid();
        $Excel_writer->save($save_path.'/movies-'.$id.'.xlsx');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);
        $reader->setLoadAllSheets();

        $sheetCount = $spreadsheet->getSheetCount();
        for ($i = 0; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getSheet($i);

            $sheetData = $sheet->toArray(null, true, true, true);

            for ($ii = 1; $ii < count($sheetData); $ii++){

                $movie = new Movie();
                $movie->title = $sheetData[2]['A'];
                $movie->year = $sheetData[2]['B'];
                $movie->user_id = $sheetData[2]['C'];
                $movie->published = $sheetData[2]['D'];
                $movie->image = $sheetData[2]['E'];
                $movie->save();

            }


        }




        Alert::success('Importation avec succés')->flash();
        return redirect()->route('movies.index');

    }

    public function emptyRow($row)
    {
        $lenght = count($row);
        for ($i = 0; $i < $lenght; $i++) {
            if ($row[$i] !== null) {
                return false;
            }
        }

        return true;
    }
}
