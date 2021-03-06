<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id','id');
    }

    public function party()
    {
        return $this->hasOne(Party::class, 'id','party_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
