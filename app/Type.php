<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Movie;

class Type extends Model
{
    protected $fillable = [
        'type','created_at', 'updated_at'
    ];

    public function movies()
    {
        return $this->belongsToMany('App\Movie' ,'movie_types' ,'type_id' ,'movie_id');
    }

}
