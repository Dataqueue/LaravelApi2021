<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\payment_account;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_accounts = PaymentAccount::all();
        return response()->json($payment_accounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->json()->all();
        // dd($request);
        $payment_account = PaymentAccount::create($request->all());
        return response()->json($payment_account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payment_account  $payment_account
     * @return \Illuminate\Http\Response
     */
    public function show(payment_account $payment_account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\payment_account  $payment_account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment_account $payment_account)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payment_account  $payment_account
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment_account $payment_account)
    {
        $payment_account->delete();
        return response()->json(['msg'=>"Successfully deleted"], 200);
    }
}
