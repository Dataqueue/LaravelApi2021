<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'payment_accounts';

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function advanceAccount()
    {
        return $this->belongsTo(AdvancePayment::class);
    }
}
