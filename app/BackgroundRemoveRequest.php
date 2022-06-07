<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackgroundRemoveRequest extends Model
{
    protected $table = 'background_remove_request';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function business()
    {
        return $this->belongsTo('App\Business', 'business_id', 'busi_id');
    }

    public function politicalBusiness()
    {
        return $this->belongsTo('App\PoliticalBusiness', 'business_id', 'pb_id');
    }
}
