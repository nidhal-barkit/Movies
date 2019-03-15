<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Movie;
use App\User;

class Role extends Model
{
    protected $fillable = [
        'type','created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
