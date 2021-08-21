<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RFQDetails;
use App\Models\RFQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RFQDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allRFQDetials = RFQDetails::all();
        return response()->json($allRFQDetials, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'rfq_id' => 'required',
            'product_id' => 'required',
            'description' => 'required',
            'quantity_required' => 'required',
        ];

        $messages = ['required' => 'The :attribute field is required.'];

        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        foreach ($errors as $error) {
            echo $error;
        }
        // echo $errors->first('email');

        // if($validator->fails()){
        // return ("somethin went wrong");


        $rfq_detail = RFQDetails::create($request->all());


        return response()->json($rfq_detail, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQDetails  $rfq_detail
     * @return \Illuminate\Http\Response
     */
    public function show(RFQDetails $rfq_detail)
    {
        $rfq = RFQ::find($rfq_detail->rfq_id);
        return response()->json([
            'rfq_detail'=>$rfq_detail,
            'rfq' => $rfq,
    ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RFQDetails  $rfq_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RFQDetails $rfq_detail)
    {
        $rules = [
            'rfq_id' => 'required',
            'product_id' => 'required',
            'description' => 'required',
            'quantity_required' => 'required',
        ];

        $messages = ['required' => 'The :attribute field is required.'];

        $validator = Validator::make($request->all(), $rules, $messages);
        $errors = $validator->errors();
        foreach ($errors as $error) {
            echo $error;
        }
        // echo $errors->first('email');

        // if($validator->fails()){
        // return ("somethin went wrong");


        $res = $rfq_detail->update($request->all());


        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RFQDetails  $rfq_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RFQDetails $rfq_detail)
    {
        $res = $rfq_detail->delete();
        if ($res) {
            return (['msg' => 'rfq_detail' . ' ' . $rfq_detail->id . ' is successfully deleted']);
        }
    }
}
