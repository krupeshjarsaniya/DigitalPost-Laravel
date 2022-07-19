<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';
    public $timestamps = false;

    static $custom_plan_id = 8;
    static $start_up_plan_id = 7;
}
