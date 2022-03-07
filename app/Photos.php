<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'photo_id';
    public $timestamps = false;
}
