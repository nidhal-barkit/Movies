<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::all()->where('published','=', 1);

        return view('welcome',compact('movies'));
    }
}
