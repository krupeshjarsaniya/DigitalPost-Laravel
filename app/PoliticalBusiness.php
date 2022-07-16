<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoliticalBusiness extends Model
{
    protected $table = 'political_business';
    public $timestamps = false;
    protected $primaryKey = 'pb_id';

    public function category() {
        return $this->belongsTo('App\PoliticalCategory', 'pb_pc_id', 'pc_id');
    }
}
