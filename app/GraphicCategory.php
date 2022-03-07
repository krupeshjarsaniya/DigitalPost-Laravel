<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Graphic;

class GraphicCategory extends Model
{
	protected $table = 'graphic_category';

	public function graphics() {
        return $this->hasMany(Graphic::class, 'graphic_id', 'id')->where('is_delete', 0);
    }
}
