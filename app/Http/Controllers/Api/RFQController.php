<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\Party;
use App\Models\RFQ;
use App\Models\RFQDetails;
use App\Models\RFQFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RFQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        $rfqs = RFQ::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('quotations')
                ->whereRaw('quotations.rfq_id = r_f_q_s.id');
        })->orderBy('created_at', 'DESC')
            ->get();

        // $rfqs = RFQ::orderBy('created_at', 'DESC')->get();
        $rfqs_data = [
            $rfqs->map(
                function ($rfq) {
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
                                "quantity" => $rfq_detail->quantity,
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
        $data = $request->json()->all();
        // return response()->json($request, 201);
        // dd($request->file('files'));

        try {
            $rfq = RFQ::create([
                'requested_date' => $request->has('requested_date') ? $request['requested_date'] : date('Y-m-d'),
                'require_date' => $request->has('require_date') ? $request['require_date'] : date('Y-m-d'),
                // 'require_date' => $data['require_date'],
                // 'requested_date' => $data['requested_date'],
                'contact_id' => $request['contact_id'],
                'party_id' => $request['party_id'],
            ]);

            //-------------------------------------------
            $index = 0;
            while ($request['myFile' . $index] != null) {
                if ($request->file('myFile' . $index)) {
                    $name = $request['myFile' . $index]->getClientOriginalName();
                    $path = $request->file('myFile' . $index)->move('rfq/' . $rfq->id, $name);
                    FileUpload::create([
                        'rfq_id' => $rfq->id,
                        'file_name' => $path
                    ]);
                }
                $index++;
            }

            global $_rfq_id;
            $_rfq_id = $rfq['id'];

            $rfq_details = json_decode($request['rfq_details'], true);

            foreach ($rfq_details as $rfq_detail) {
                RFQDetails::create([
                    'product_id' => $rfq_detail['id'],
                    'description' => $rfq_detail['descriptionss'],
                    'quantity' => $rfq_detail['quantity'],
                    'rfq_id' => $_rfq_id,
                ]);
            }



            // if($request->hasFile('files')){
            //     foreach($request->files as $file){
            //         print_r($name);
            //     }
            // }else{
            //     return 'No files has been added.';
            // }

            // $name = $request->file('files')->getClientOriginalName();
            // $res = $request->file('files')->storeAs('rfqDocs/' . $_rfq_id , $name);
            // $fileUpload = FileUpload::create([
            //     'rfq_id' => $_rfq_id,
            //     'file_name' => $res,
            // ]);
            return response()->json(['msg' => 'successfully added']);
            // return ([
            //     'data' => $request->all(),
            // ]);
        } catch (Exception $e) {
            return response()->json($e, 400);
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


        if ($rfq->file) {
            foreach ($rfq->file as $img) {
                $img['img_url'] = url($img->file_name);
            }
        }


        $data = [
            'id' => $rfq->id,
            'requested_date' => $rfq->requested_date,
            'require_date' => $rfq->require_date,
            'party_id' => $rfq->party_id,
            'user_id' => $rfq->user_id,
            'created_at' => $rfq->created_at,
            'updated_at' => $rfq->updated_at,
            'files' => $rfq->file ? $rfq->file : null,
            "party" => $rfq->party,
            "contact" => $rfq->contact,
            'rfq_details' => $rfq->rfq_details->map(function ($rfq_detail) {
                $rfq_detail = RFQDetails::where('id', '=', $rfq_detail->id)->first();
                return [
                    "id" => $rfq_detail['id'],
                    "created_at" => $rfq_detail->created_at,
                    "updated_at" => $rfq_detail->updated_at,
                    "product_id" => $rfq_detail->product_id,
                    "quantity" => $rfq_detail->quantity,
                    "description" => $rfq_detail->description,
                    "product_name" => $rfq_detail->product->name,
                    "product" => array($rfq_detail->product),
                    "prices" => $rfq_detail->product->productPrice,
                    "party" => $rfq_detail->product->productPrice->map(function ($price) {
                        return ($price->party);
                    }),
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
    public function update(Request $request) //, RFQ $rfq
    {
        // $rules = [
        //     'requested_date' => 'required',
        //     'require_date' => 'required',
        //     'party_id' => 'required',
        //     'user_id' => 'required',
        // ];


        // $messages = [
        //     'required' => 'The :attribute field is required.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);
        // $errors = $validator->errors();
        // foreach ($errors as $error) {
        //     echo $error;
        // }
        // $data = $request->json()->all();

        

        $rfq = RFQ::where('id', $request->rfq_id)->first();
        if (!$rfq) {
            return response()->json(['There is no RFQ with id' . $request->rfq_id]);
        }

        $data = json_decode($request['rfq_details'], true);
        // return $request;
        try {
            $rfq->update([
                'requested_date' => $request->requested_date,
                'require_date' => $request->require_date,
                // 'contact_id' => $request->contact_id,
            ]);

            $index = 0;
            while ($request['myFile' . $index] != null) {
                if ($request->file('myFile' . $index)) {
                    $name = $request['myFile' . $index]->getClientOriginalName();
                    $path = $request->file('myFile' . $index)->move('rfq/' . $rfq->id, $name);
                    FileUpload::create([
                        'rfq_id' => $rfq->id,
                        'file_name' => $path
                    ]);
                }
                $index++;
            }

            global $_rfq_id;
            $_rfq_id = $rfq['id'];
            $temp = json_decode($request['rfq_details'], true);
            foreach ((array) $temp as $rfq_detail) {
                $rfq_update_data = RFQDetails::where('id',$rfq_detail['id'])->first();
                if ($rfq_update_data) {
                    $_rfq_detail = $rfq_update_data->update([
                        'product_id' => $rfq_detail['product_id'],
                        'description' => $rfq_detail['description'],
                        'quantity' => $rfq_detail['quantity'],
                        // 'rfq_id' => $_rfq_id,
                    ]);
                }else{
                    RFQDetails::create([
                        'product_id' => $rfq_detail['product_id'],
                        'description' => $rfq_detail['description'],
                        'quantity' => $rfq_detail['quantity'],
                        'rfq_id' => $_rfq_id
                    ]);
                }
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

    public function history()
    {
        $rfqs = RFQ::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('quotations')
                ->whereRaw('quotations.rfq_id = r_f_q_s.id');
        })->orderBy('created_at', 'DESC')
            ->get();
        return response()->json($rfqs);
    }
}

//////////////
//
//
//
//
//
//
//
