<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    public function category()
    {
        return $this->belongsTo('App\MusicCategory', 'category_for');
    }
}
