<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class PaymentDetail extends Model
{
	protected $table = 'payment_details';

	public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
