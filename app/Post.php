<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // create relaion users and posts
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
        return $this->hasMany(Likes::class,'posts_id');
    }

    public function comments(){
        return $this->hasMany(Comments::class,'posts_id');
    }
}
