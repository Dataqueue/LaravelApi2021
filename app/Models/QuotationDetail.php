<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuotationDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function party()
    {
        return $this->hasOne(Party::class, 'id', 'party_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getDeliveredQuantity(QuotationDetail $quotation_detail)
    {
        $deliveryNoteDetails = DB::table('delivery_notes')
        ->leftJoin('delivery_note_details', 'delivery_note_details.delivery_note_id','=', 'delivery_notes.id')
        ->where('delivery_notes.quotation_id',$quotation_detail->quotation_id)
        ->where('delivery_note_details.product_id', $quotation_detail->product_id)
        ->get();

        if($deliveryNoteDetails) {
            $totalDeliveryNoteDetail = 0;
            foreach ($deliveryNoteDetails as $item) {
                $totalDeliveryNoteDetail += intval($item->delivered_quantity);
            }
            return $totalDeliveryNoteDetail;
        }
        return 0;
    }
}
