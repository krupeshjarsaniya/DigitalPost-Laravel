<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrameComponent extends Model
{
	protected $table = 'frame_components';

    public function frame()
    {
        return $this->belongsTo('App\Frame');
    }

    public function field()
    {
        return $this->belongsTo('App\BusinessField', 'image_for');
    }
}
