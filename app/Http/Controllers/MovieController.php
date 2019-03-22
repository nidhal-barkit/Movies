<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Movie;
use App\MovieType;
use App\Type;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Mail;
use mikehaertl\wkhtmlto\Pdf;

class MovieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));

    }



    public function create()
    {
        $types = Type::all();
        if (Auth::user()->getRole() =='User'){
            return view('movies.create', compact('types'));
        }

    }

    public function store(Request $request)
    {
        $movie = new Movie();
        $movie->title = $request->get('titre');
        $movie->year = $request->get('year');
        $movie->user_id = Auth::user()->id;
        if (isset($request->published)) {
            $movie->published = 1;
        }else{
            $movie->published = 0;
        }
        if ($request->hasFile('image')) {
            $id = uniqid();
            $image = $request->file('image');
            $filename = $id.'.'.$image->getClientOriginalExtension();
            $input ['image'] = $id.'.'.$image->getClientOriginalExtension();
            $img =\Image::make($image->getRealPath());
            $destinationPath = public_path('/images');

            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['image']);
            $date =  new \DateTime();
            $movie->image ='/images/'.$filename.'?v='.$date->getTimestamp();
        }

        if($movie->save())
        {
            $types_array = $request->get('types');
            $movie->types()->attach($types_array);

            Alert::success('Nouveau Film a été enregisté avec succés')->flash();
        }else{
            Alert::warning('erreur')->flash();
        }
        return redirect()->route('movies.index');
    }

    public  function edit($id){
        $movie = Movie::find($id);
        $types = Type::all();
        return view('movies.edit', compact('movie','types'));
    }

    public function update(Request $request , $id)
    {
        $movie = Movie::find($id);
        $this->authorize('update' , $movie);
        $movie->title = $request->get('titre');
        $movie->year = $request->get('year');
        if (isset($request->published)) {
            $movie->published = 1;
        }else{
            $movie->published = 0;
        }

        if ($request->hasFile('image') != null) {
            /*if ($movie->image != null){
                $url= explode('?', $movie->image);
                $part1 = $url[0];
                unlink(public_path($part1));
            }*/
            $idd = uniqid();
            $image = $request->file('image');
            $filename = $idd.'.'.$image->getClientOriginalExtension();
            $input ['image'] = $idd.'.'.$image->getClientOriginalExtension();
            $img =\Image::make($image->getRealPath());
            $destinationPath = public_path('/images');
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['image']);
            $date =  new \DateTime();
            $movie->image ='/images/'.$filename.'?v='.$date->getTimestamp();
        }

        if($movie->save())
        {
            $types_array = $request->get('types');
            $movie->types()->sync($types_array,false);
            Alert::success('Film a été modifiée avec succés')->flash();
        }else{
            Alert::warning('erreur')->flash();
        }
        return redirect()->route('movies.edit', [$id]);
    }

    public  function destroy(Request $request , Movie $movie){

        $this->authorize('delete' , $movie);
        $movie = Movie::where('id',$request->get('id'))->get()->first();

        if($movie->delete())
        {
            MovieType::where('movie_id',$movie->id)->delete();

            /*
             $url= explode('?', $movie->image);
            $part1 = $url[0];
            unlink(public_path($part1));
            */

            $data =array(
                'name' => $movie->title,
                'image' => $movie->image,
                'username' => $movie->getUserName(),
                'message' => 'Votre film a été supprimé',
            );

            Mail::to($movie->getUserMail())->send(new SendMail($data));
            Alert::success('Film a été supprimé avec succés')->flash();
        }else{
            Alert::warning('erreur')->flash();
        }
        return redirect()->route('movies.index');

    }



    public function generatePDF ()
    {
        $pdf = new Pdf([
            'binary'         => config('app.wkhtmltox.pdf'),
            'ignoreWarnings' => true,
            'commandOptions' => ['useExec' => true],
        ]);

        $movies = Movie::all();
        $pdf->addPage(view('myPDF',['movies' => $movies]));

        $file_name = 'movies - 2019 - '.uniqid().'.pdf';
        $save_path = public_path("/generation/");
        if (! file_exists($save_path) && ! mkdir($save_path, 0777, true) && ! is_dir($save_path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $save_path));
        }
        $pdf->saveAs($save_path . $file_name);
        $pdf->send($file_name);

        return [
            'generated_movies' => empty($pdf->getError()),
            'url'              => empty($pdf->getError()) ? "/generation/$file_name" : null,
            'file_name'        => $file_name,
            'errors_movies'    => ! empty($pdf->getError()) ? utf8_encode($pdf->getError()) : null
        ];

    }
}
