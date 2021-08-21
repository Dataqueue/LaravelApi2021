<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use App\Models\RFQ;
use App\Http\Controllers\Api\RFQDetails;
use Illuminate\Support\Facades\File;



class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // $rfq = RFQ::create();
        // global $rfq_id ;
        // $rfq_id = $rfq->id;
        //     if($request->hasFile('files')){
        //         foreach($request->files as $file){
        //             $name = $request->file('files')->getClientOriginalName();
        //             print_r($name);
        //             $res = $request->file('files')->storeAs('rfqDocs/' . $rfq_id , $name);
        //             $fileUpload = FileUpload::create([
        //                 'rfq_id' => $rfq_id,
        //                 'file_name' => $res,
        //                 ]);
        //         }
        //     }else{
        //         return 'No files has been added.';
        //     }
        // return [
        //     'data'=>$request->all(),
        //     'file_path' => $request->file['files']->store('rfqDocs'),
        //     'file'=> $request->files,
        // ];
        // // return $request->file('files')->store('rfqDocs');

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUpload $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUpload $fileUpload)
    {
        if (File::exists(public_path($fileUpload->file_name))) {

            File::delete(public_path($fileUpload->file_name));
        }
        // else {

        //     dd('File does not exists.');
        // }

        $fileUpload->delete();

        return response()->json(['msg'=>"Successfully File Deleted"]);

    }
}
