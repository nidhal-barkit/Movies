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


class MyMovieController extends Controller
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
        $movies = Movie::all()->where('user_id','=',Auth::user()->id);
        return view('MyMovies.index', compact('movies'));
    }

    public function create()
    {
        $types = Type::all();
        return view('MyMovies.create', compact('types'));
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
        return redirect('/mymovies');
    }

    public  function edit($id){
        $movie = Movie::find($id);
        $types = Type::all();
        return view('MyMovies.edit', compact('movie','types'));
    }

    public function update(Request $request , $id)
    {
        $movie = Movie::find($id);

        $movie->title = $request->get('titre');
        $movie->year = $request->get('year');
        $movie->user_id = Auth::user()->id;
        if (isset($request->published)) {
            $movie->published = 1;
        }else{
            $movie->published = 0;
        }

        if ($request->hasFile('image') != null) {

            $url= explode('?', $movie->image);
            $part1 = $url[0];
            unlink(public_path($part1));

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
            $movie->types()->sync($types_array);
            Alert::success('Film a été modifiée avec succés')->flash();
        }else{
            Alert::warning('erreur')->flash();
        }
        return redirect()->route('mymovies.edit', [$id]);

    }

    public  function destroy(Request $request){
        $movie = Movie::where('id',$request->get('id'))->get()->first();
        $url= explode('?', $movie->image);
        $part1 = $url[0];
        unlink(public_path($part1));
        if($movie->delete())
        {
            Alert::success('Film a été supprimé avec succés')->flash();
        }else{
            Alert::warning('erreur')->flash();
        }

        return redirect()->route('mymovies.index');

    }
}
