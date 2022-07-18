<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorBusinessFrame extends Model
{

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function distributor() {
        return $this->belongsTo('App\DistributorChannel', 'distributor_id', 'id');
    }
}
