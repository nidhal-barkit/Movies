<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Movie;



class ApiMovieController extends Controller
{

    public function getUserMovies($id)
    {
        $movies = Movie::all()->where('user_id',$id);
        return response()->json($movies);
    }


}
