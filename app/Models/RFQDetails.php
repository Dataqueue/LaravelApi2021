<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFQDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rfq()
    {
        return $this->belongsTo(RFQ::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function analyse()
    {
        return $this->belongsTo(analyse::class);
    }
}
