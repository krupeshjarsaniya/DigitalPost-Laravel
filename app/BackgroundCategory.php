<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Background;

class BackgroundCategory extends Model
{
	protected $table = 'background_category';

	public function backgrounds() {
        return $this->hasMany(Background::class, 'category_id', 'id')->where('is_delete', 0);
    }
}