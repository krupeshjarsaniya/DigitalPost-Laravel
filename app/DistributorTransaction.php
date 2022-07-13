<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorTransaction extends Model
{
    public function distributor() {
        return $this->belongsTo(DistributorChannel::class, 'distributor_id');
    }
}
