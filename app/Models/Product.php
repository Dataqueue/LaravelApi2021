<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function division()
    {
        return $this->belongsTo(Division::class, 'rfq_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'rfq_id');
    }
    public function rfq()
    {
        return $this->belongsTo(RFQDetails::class, 'rfq_id');
    }
    public function rfq_detail()
    {
        return $this->belongsTo(RFQ::class);
    }
    public function quotaionDetail()
    {
        return $this->belongsTo(QuotationDetail::class);
    }

    public function invoiceDetail()
    {
        return $this->belongsTo(InvoiceDetail::class);
    }
    public function purchaseInvoiceDetail()
    {
        return $this->belongsTo(PurchaseInvoiceDetail::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function productPrice()
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }

    public function deliveryNoteDetail()
    {
        return $this->hasOne(DeliveryNoteDetail::class, 'product_id', 'id');
    }
}
