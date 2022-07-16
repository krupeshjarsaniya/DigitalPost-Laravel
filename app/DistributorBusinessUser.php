<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorBusinessUser extends Model
{
    protected $table = 'distributors_business_users';

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
