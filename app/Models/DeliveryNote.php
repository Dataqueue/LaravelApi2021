<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function deliveryNoteDetail()
    {
        return $this->hasMany(DeliveryNoteDetail::class, 'delivery_note_id', 'id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class,'id', 'quotation_id');
    }
}
