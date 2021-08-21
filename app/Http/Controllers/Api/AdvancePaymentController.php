<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdvancePayment;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPayments = AdvancePayment::all();

        $allPayments->map(function($payment){
            return $payment->paymentAccount;
        });

        return response()->json($allPayments);
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

        $payment = AdvancePayment::create($data);

        return response()->json($payment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function show(AdvancePayment $advancePayment)
    {
        return response()->json($advancePayment, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvancePayment $advancePayment)
    {
        $advancePayment->update($request->all());

        return response()->json($advancePayment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvancePayment  $advancePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvancePayment $advancePayment)
    {
        $advancePayment->delete();

        return response()->json(['msg'=>"Successfully destroyed"], 200);
    }
}
