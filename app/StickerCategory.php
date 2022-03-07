<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sticker;

class StickerCategory extends Model
{
	protected $table = 'sticker_category';

	public function stickers() {
        return $this->hasMany(Sticker::class, 'category_id', 'id')->where('is_delete', 0);
    }
}