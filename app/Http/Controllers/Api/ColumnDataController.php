<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ColumnData;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ColumnDataController extends Controller
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
        $data = $request->all();
        $columnData = ColumnData::create($data);

        return response()->json($columnData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ColumnData  $columnData
     * @return \Illuminate\Http\Response
     */
    public function show($expenseId)
    {
        $columnDatas = ColumnData::where('expense_id', $expenseId)->get();
        if($columnDatas == isEmpty()){
            return response("There is no data for Expense Id: ".$expenseId." \n Add new data entries");
        } else {
            $data = $columnDatas->map(function ($columnData){
                return [
                    "data_values" => $columnData,
                    "column_name" => $columnData->column->name,
                ];
            });

            $data['accountCategory'] = $columnDatas[0]->column->accountCategory;

            return response()->json($data);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ColumnData  $columnData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ColumnData $columnData)
    {
        $data = $request->all();
        $columnData->update($data);

        return response()->json($columnData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ColumnData  $columnData
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColumnData $columnData)
    {
        $columnData->delete();

        return response()->json($columnData->id . " has been successfully deleted.");
    }
}
