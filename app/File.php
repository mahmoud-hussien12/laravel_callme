<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function posts(){
        return $this->belongsToMany('App\Post', 'post_file', 'post_id', 'file_id');
    }
}
