<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartyBank;
use Illuminate\Http\Request;

class PartyBankController extends Controller
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
        $bank = PartyBank::create([
            'account_no' => $request->account_no,
            'iban_no' => $request->iban_no,
            'bank_name' => $request->bank_name,
            'bank_address' => $request->bank_address,
            'party_id'=> $request->party_id,
        ]);

        return response()->json($bank);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartyBank  $partyBank
     * @return \Illuminate\Http\Response
     */
    public function show(PartyBank $partyBank)
    {
        return response()->json($partyBank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartyBank  $partyBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartyBank $partyBank)
    {
        $partyBank->update($request->all());

        return response()->json($partyBank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartyBank  $partyBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartyBank $partyBank)
    {
        $partyBank->delete();

        return response()->json(['msg'=>"Successfully Deleted"]);
    }
}
