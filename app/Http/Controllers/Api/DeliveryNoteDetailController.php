<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryNoteDetail;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;

class DeliveryNoteDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_notes_details = DeliveryNoteDetail::all();
        $data = [
            $delivery_notes_details->map(function ($delivery_notes_detail) {
                return [
                    $delivery_notes_detail,
                    $delivery_notes_detail->product,
                ];
            }),
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $delivery_notes_detail = DeliveryNoteDetail::create($data);

        return response()->json($delivery_notes_detail);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryNoteDetail $delivery_notes_detail
     * @return \Illuminate\Http\Response
     *
     *
     */

    public function getTotalDeliveredQuantity($val)
    {
        if(isset($val)){
            $totalDeliveryNoteDetail = 0;
            foreach($val as $item){
                $totalDeliveryNoteDetail += intval($item->delivered_quantity);
            }
            return $totalDeliveryNoteDetail;
        }
        return 0;
    }

    // there is no need for this
    public function getBalanceQuantity($totalQuantity = 0, $totalDeliveredQuantity = 0)
    {
        return ($totalQuantity - $totalDeliveredQuantity);
    }

    public function show(DeliveryNoteDetail $delivery_notes_detail)
    {
        $totalDeliveryNoteDetail = DeliveryNoteDetail::where([
            'delivery_note_id' => $delivery_notes_detail->delivery_note_id,
            'product_id' => $delivery_notes_detail->product_id,
        ])->get();

        $quotationDetail = QuotationDetail::where([
            'quotation_id' => $delivery_notes_detail->deliveryNote->quotation_id,
            'product_id'=> $delivery_notes_detail->product_id,
        ])->firstOrFail();

        $totalDeliveredQuantity = $this->getTotalDeliveredQuantity($totalDeliveryNoteDetail);

        $data = [
            "total_quantity"=>$totalQuantity = $quotationDetail->quantity,
            "total_delivered_quantity"=>$totalDeliveredQuantity,
            'balance_quantity' => $this->getBalanceQuantity($totalQuantity, $totalDeliveredQuantity),
            "delivery_notes_detail"=>$delivery_notes_detail,
            "quotation"=>$delivery_notes_detail->deliveryNote->quotation,
            "delivery_note"=>$delivery_notes_detail->deliveryNote,
            "party"=>$delivery_notes_detail->deliveryNote->quotation->party,
            "product"=>$delivery_notes_detail->product,
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryNoteDetail $delivery_notes_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryNoteDetail $delivery_notes_detail)
    {
        $data = $request->json()->all();
        $delivery_notes_detail->update($data);

        return response()->json($delivery_notes_detail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryNoteDetail $delivery_notes_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryNoteDetail$delivery_notes_detail)
    {
        $delivery_notes_detail->delete();

        return response()->json(['msg' => "Delivery Note Detail with id: " .$delivery_notes_detail->id . " has successfully Deleted"]);
    }
}
