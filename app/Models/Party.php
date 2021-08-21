<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rfq()
    {
        return $this->belongsTo(RFQ::class);
    }
    public function rfq_detail()
    {
        return $this->belongsTo(RFQDetails::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class,'party_id','id');
    }

    public function quotationDetail()
    {
        return $this->belongsTo(QuotationDetail::class);
    }

    public function productPrice()
    {
        return $this->belongsTo(ProductPrice::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function bank()
    {
        return $this->hasMany(PartyBank::class,'party_id','id');
    }
}
