<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MusicCategory extends Model
{
    public function musics() {
        return $this->hasMany(Music::class, 'category_id', 'id')->where('is_delete', 0);
    }
}
