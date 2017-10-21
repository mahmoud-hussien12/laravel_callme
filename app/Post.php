<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function files(){
        return $this->belongsToMany('App\File', 'post_file', 'post_id', 'file_id');
    }
}
