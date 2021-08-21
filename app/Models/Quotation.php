<?php

namespace App\Models;

use App\Http\Controllers\Api\PurchaseInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quotationDetail()
    {
        return $this->hasMany(QuotationDetail::class,'quotation_id','id');
    }
    public function party()
    {
        return $this->hasOne(Party::class, 'id','party_id');
    }

    public function rfq()
    {
        return $this->hasOne(RFQ::class, 'id', 'rfq_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'quotation_id', 'id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function purchaseInvoice()
    {
        return $this->hasOne(PurchaseInvoice::class, 'quotation_id', 'id');
    }

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }
}
