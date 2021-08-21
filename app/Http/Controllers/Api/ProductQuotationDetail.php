<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;

class ProductQuotationDetail extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotationDetails = QuotationDetail::where('product_id',$id)->get();
        if($quotationDetails == null){
            return response(['msg'=>'There is no data available']);
        }
        else{
            $data = $quotationDetails->map(function ($quotationDetail){
                return[
                'firm_name' => $quotationDetail->quotation->party ? $quotationDetail->quotation->party->firm_name : "Party is Empty",
                'sellprice' => $quotationDetail->sell_price,
                'purchase_price' => $quotationDetail->purchase_price,
                'margin' => $quotationDetail->margin,
                ];
            });
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
