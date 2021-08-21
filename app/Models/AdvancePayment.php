<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function paymentAccount()
    {
        return $this->hasOne(PaymentAccount::class, 'id','payment_account_id');
    }
}
