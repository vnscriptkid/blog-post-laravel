<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    // find a profile of an author
    // SELECT * FROM profiles WHERE author_id = [X]
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
}
