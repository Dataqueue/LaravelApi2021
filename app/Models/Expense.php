<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'paid_by', 'id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'referrence_bill_no', 'id');
    }

    public function payment_account()
    {
        return $this->hasMany(PaymentAccount::class,'id','payment_account_id');
    }

    public function column_data()
    {
        return $this->hasMany(ColumnData::class, 'expense_id','id');
    }

    public function img()
    {
        $path = $this->bank_slip;
        if (File::exists(public_path($this->bank_slip))) {
            return url($path);
        }
        return "No file Uploaded";

    }

    public function referrenceImg()
    {
        $path = $this->file_path;
        if (File::exists(public_path($this->file_path))) {
            return url($path);
        }
        return "No file Uploaded";

    }
}

