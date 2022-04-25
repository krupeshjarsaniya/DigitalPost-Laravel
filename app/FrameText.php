<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrameText extends Model
{
	protected $table = 'frame_texts';

    public function frame()
    {
        return $this->belongsTo('App\Frame');
    }

    public function field()
    {
        return $this->belongsTo('App\BusinessField', 'text_for');
    }
}
