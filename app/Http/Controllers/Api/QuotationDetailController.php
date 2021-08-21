<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;

class QuotationDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q_details = QuotationDetail::all();
        return response()->json($q_details);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quotation_detail = QuotationDetail::create($request->all());
        return $quotation_detail;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuotationDetail  $quotationDetail
     * @return \Illuminate\Http\Response
     */
    public function show(QuotationDetail $quotationDetail)
    {
        return response()->json($quotationDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuotationDetail  $quotationDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuotationDetail $quotationDetail)
    {
        $quotation_detail = $quotationDetail->update($request->all());
        return $quotation_detail;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuotationDetail  $quotationDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuotationDetail $quotationDetail)
    {
        QuotationDetail::delete($quotationDetail);
    }
}
