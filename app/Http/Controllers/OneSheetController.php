<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Movie;
use Prologue\Alerts\Facades\Alert;

class OneSheetController extends Controller
{
    public function  export()
    {

        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $row = 2;
        $filename ='Movies';

        $movies= Movie::all();
            foreach($movies as $movie)
            {

                $activeSheet->setCellValue('A1', 'Titre');
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

}
