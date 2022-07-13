<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorChannel extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
}
