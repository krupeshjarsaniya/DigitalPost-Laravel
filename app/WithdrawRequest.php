<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class WithdrawRequest extends Model
{
	protected $table = 'withdraw_request';

	public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
