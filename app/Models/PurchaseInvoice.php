<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaseInvoiceDetail()
    {
        return $this->hasMany(PurchaseInvoiceDetail::class, 'purchase_invoice_id', 'id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function PurchaseInvoice()
    {
        return $this->hasMany(RFQ::class, 'id', 'rfq_id');
    }
    
}
