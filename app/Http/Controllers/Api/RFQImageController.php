<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\RFQ;
use App\Models\RFQDetails;
use App\Models\FileUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class RFQImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rfqs = RFQ::all();
        $rfqs_data = [
            $rfqs->map(
                function ($rfq) {
                    // $party = Party::findOrFail($rfq->party_id);
                    // return [
                    //     'id' => $rfq->id,
                    //     'requested_date' => $rfq->requested_date,
                    //     'require_date' => $rfq->require_date,
                    //     'party_id' => $rfq->party_id,
                    //     'party_fname' => $party ? $party->fname : $party,
                    //     'party_lname' => $party ? $party->lname : $party,
                    //     'user_id' => $rfq->user_id,
                    //     'created_at' => $rfq->created_at,
                    //     'updated_at' => $rfq->updated_at,

                    // ];
                    //
                    //
                    return [
                        'id' => $rfq->id,
                        'requested_date' => $rfq->requested_date,
                        'require_date' => $rfq->require_date,
                        'party_id' => $rfq->party_id,
                        "party" => $rfq->party,
                        'user_id' => $rfq->user_id,
                        'created_at' => $rfq->created_at,
                        'updated_at' => $rfq->updated_at,
                        'rfq_details' => $rfq->rfq_details->map(function ($rfq_detail) {
                            $rfq_detail = RFQDetails::where('id', '=', $rfq_detail->id)->first();
                            return [
                                "id" => $rfq_detail['id'],
                                "created_at" => $rfq_detail->created_at,
                                "updated_at" => $rfq_detail->updated_at,
                                "product_id" => $rfq_detail->product_id,
                                "product" => array($rfq_detail->product),
                                "description" => $rfq_detail->description,
                                "quantity_required" => $rfq_detail->quantity_required,
                            ];
                        }),
                    ];
                }
            ),
        ];
        return response()->json($rfqs_data[0], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        // dd($request->file('files'));

        try {
            $rfq = RFQ::create([
                'requested_date' => $request->has('requested_date') ? $data['requested_date'] : date('Y-m-d'),
                'require_date' => $request->has('require_date') ? $data['require_date'] : date('Y-m-d'),
                // 'require_date' => $data['require_date'],
                // 'requested_date' => $data['requested_date'],
                'party_id' => $request['party_id'],
            ]);
            // return $rfq;
            global $_rfq_id;
            $_rfq_id = $rfq['id'];

            // if ($data['rfq_details']!=null){
            // // return $data->rfq_details;
            // $rfq_details = $data->rfq_details->map(function ($rfq_detail){

            // });

            $rfq_details = $request->rfq_details->map(function ($rfq_detail, $_rfq_id){
                return[
                RFQDetails::create([
                    'product_id' => $rfq_detail['id'],
                    'description' => $rfq_detail['descriptionss'],
                    'quantity_required' => $rfq_detail['quantity'],
                    'rfq_id' => $_rfq_id,
                ])
                ];
            });

            foreach ($request->rfq_details as $rfq_detail) {
                $_rfq_detail = RFQDetails::create([
                    'product_id' => $rfq_detail['id'],
                    'description' => $rfq_detail['descriptionss'],
                    'quantity_required' => $rfq_detail['quantity'],
                    'rfq_id' => $_rfq_id,
                ]);
            }

            // }


            // if($request->hasFile('files')){
            //     foreach($request->files as $file){
            //         print_r($name);
            //     }
            // }else{
            //     return 'No files has been added.';
            // }

            $name = $request->file('files')->getClientOriginalName();
            $res = $request->file('files')->storeAs('rfqDocs/' . $_rfq_id , $name);
            $fileUpload = FileUpload::create([
                'rfq_id' => $_rfq_id,
                'file_name' => $res,
            ]);
            // return response()->json(['msg' => 'successfully added']);
            return ([
                'data' => $request->all(),
                'files' => $request->file('files')->getClientOriginalName(),
            ]);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQ  $rfq
     * @return \Illuminate\Http\Response
     */
    public function show(RFQ $rfq)
    {
        // $_rfq = RFQ::findOrFail($rfq);

        // $rfq_details = DB::table('r_f_q_s')
        // ->leftJoin('r_f_q_details', 'r_f_q_s.id','=', 'r_f_q_details.rfq_id')
        // ->where('r_f_q_s.id',$rfq)
        // ->get();

        // return $_rfq->rfq_details;
        $data = [
            'id' => $rfq->id,
            'requested_date' => $rfq->requested_date,
            'require_date' => $rfq->require_date,
            'party_id' => $rfq->party_id,
            "party" => $rfq->party,
            'user_id' => $rfq->user_id,
            'created_at' => $rfq->created_at,
            'updated_at' => $rfq->updated_at,
            'rfq_details' => $rfq->rfq_details->map(function ($rfq_detail) {
                $rfq_detail = RFQDetails::where('id', '=', $rfq_detail->id)->first();
                return [
                    "id" => $rfq_detail['id'],
                    "created_at" => $rfq_detail->created_at,
                    "updated_at" => $rfq_detail->updated_at,
                    "product_id" => $rfq_detail->product_id,
                    "product" => array($rfq_detail->product),
                    "description" => $rfq_detail->description,
                    "quantity_required" => $rfq_detail->quantity_required,
                ];
            }),
        ];
        // dd($data);
        return response()->json([
            // $rfq_,
            $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RFQ  $rfq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RFQ $rfq)
    {


        $data = $request->json()->all();

        try {
            $rfq->update([
                'requested_date' => $data['requested_date'],
                'require_date' => $data['require_date'],
                'party_id' => $data['party_id'],
            ]);


            global $_rfq_id;
            $_rfq_id = $rfq['id'];

            foreach ($data['rfq_details'] as $rfq_detail) {
                $rfq_update_data = RFQDetails::findOrFail($rfq_detail['id']);
                $_rfq_detail = $rfq_update_data->update([
                    'product_id' => $rfq_detail['id'],
                    'description' => $rfq_detail['descriptionss'],
                    'quantity_required' => $rfq_detail['quantity'],
                    'rfq_id' => $_rfq_id,
                ]);
            }

            return response()->json(['msg' => 'successfully updated']);
        } catch (Exception $e) {
            return $e;
        }


        // return response()->json($rfq, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RFQ  $rfq
     * @return \Illuminate\Http\Response
     */
    public function destroy(RFQ $rfq)
    {
        $res = $rfq->delete();
        if ($res) {
            return (['msg' => 'RFQ' . ' ' . $rfq->id . ' is successfully deleted']);
        }
    }
}
