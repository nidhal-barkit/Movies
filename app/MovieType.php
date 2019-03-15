<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieType extends Model
{
    protected $table ='movie_types';
    protected $fillable = [
        'movie_id','type_id',
    ];
    public $timestamps = false;


}
