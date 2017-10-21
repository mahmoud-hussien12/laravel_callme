<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $friendsIdArray = [];
    protected $fillable = [
        'name', 'email', 'password','image_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts(){
        return $this->hasMany('App\Post');
    }
    public function viewablePosts(){
        $this->getFriends();
        $posts = Post::whereIn('user_id', $this->friendsIdArray)->get();
        return $posts;
    }
    public function files(){
        return $this->hasMany('App\File');
    }
    public function getFriends(){
        $friendsArray = [];
        $this->friendsIdArray = [];
        foreach ($this->friends as $friend){
            array_push($friendsArray, $friend);
            array_push($this->friendsIdArray, $friend->id);
        }
        foreach ($this->myFriends as $friend){
            array_push($friendsArray, $friend);
            array_push($this->friendsIdArray, $friend->id);
        }
        return $friendsArray;
    }
    public function friends(){
        $friends1 = $this->belongsToMany('App\User', 'friendships', 'user_id', 'friend_id')->wherePivot('status', '11');
        return $friends1;
    }
    public function myFriends(){
        $friends2 = $this->belongsToMany('App\User', 'friendships', 'friend_id', 'user_id')->wherePivot('status', '11');
        return $friends2;
    }
}
