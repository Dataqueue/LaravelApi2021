<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFQ extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rfq_details()
    {
        return $this->hasMany(RFQDetails::class, 'rfq_id');
    }

    public function party()
    {
        return $this->hasMany(Party::class,'id','party_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class,'id');
    }

    public function file()
    {
        return $this->hasMany(FileUpload::class, 'rfq_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class,'id', 'contact_id');
    }
}
