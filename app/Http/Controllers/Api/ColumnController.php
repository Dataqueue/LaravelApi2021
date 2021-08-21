<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = Column::all();

        return response()->json($columns, 200);
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
        $accountCategoryId = $request->account_category_id;
        foreach ($data as $column ) {
            if($column == $accountCategoryId){
                continue;
            }
            Column::create(
                [
                    'account_category_id' => $accountCategoryId,
                    'name' => $column['name'],
                    'type' => $column['type'],
                ]
            );

        }

        return response()->json(['msg'=>'Successfully added'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accountCategory = AccountCategory::where('id',$id)->first();
        if ($accountCategory == null) {
            // Account Category not found, show 404 or whatever you want to do
            return response()->json("There is no Account Category with id: ".$id);
        } else {
            // if account categoty is found then try finding the columns associated with respective category
            $columns = Column::where('account_category_id',$accountCategory->id)->get();
            if ($columns == null) {
                // Columns not found, show 404 or whatever you want to do
                return response()->json("There is no Column for Account Category with id: " . $id .".\n Create new column");
            } else {
                // if columns are available then proceed the following
                $data = [
                    $accountCategory,
                    $accountCategory->column
                ];

                return response()->json($data);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Column $column)
    {
        $data = $request->all();
        $column->update($data);

        return response()->json($column);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Column $column)
    {
        $column->delete();

        return response()->json($column->name." has been successfully deleted.");
    }
}
