<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Type;
class Movie extends Model
{
    protected $table= 'movies';
    protected $fillable = [
        'title', 'image', 'year','user_id', 'published','created_at', 'updated_at'
    ];

    public function types()
    {
        return $this->belongsToMany('App\Type' ,'movie_types' ,'movie_id' ,'type_id');
    }

    public function getUserName(){
        return User::all()->where('id','=', $this->user_id)->first()->name;
    }

    public function getUserMail(){
        return User::all()->where('id','=', $this->user_id)->first()->email;
    }



}
