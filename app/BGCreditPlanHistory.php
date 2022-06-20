<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BGCreditPlanHistory extends Model
{
    protected $table = 'bg_credit_plan_history';

    public function plan()
    {
        return $this->belongsTo('App\BGCreditPlan', 'plan_id', 'id');
    }
}
