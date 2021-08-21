<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountCategory;
use Illuminate\Http\Request;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function checkSubcategories($id)
    {
        $groupedCategories = AccountCategory::all()->groupBy('parent_id');
        // dd($groupedCategories[0]);
        if($groupedCategories->has($id)){
            $temp = $groupedCategories[$id];
            $data = [
                $temp->map(function ($category){
                    return  [
                        'category'=>$category,
                        'sub_categories'=>$this->checkSubcategories($category->id)];
                }
            ),
            ];
            return $data[0];
        }
        return $this->subCategory($id);
    }

    public function index()
    {
        // $groupedCategories = AccountCategory::all()->groupBy('parent_id');
        // dd($groupedCategories[0]);
        $accountCategories = AccountCategory::where('parent_id', '=', null)->get();
        $data = [
            // $accountCategories,
            $accountCategories->map(function($accountCategory){
            return [
                'category' => $accountCategory,
                'sub_categories' => $this->checkSubcategories($accountCategory->id),
                // 'sub_categories' => $this->subCategory($accountCategory->id),
            ];
        }),
    ];

        return response()->json($data[0]);
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
        $accountCategory = AccountCategory::create($data);

        return response()->json($accountCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AccountCategory $accountCategory)
    {
        return response()->json($accountCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountCategory $accountCategory)
    {
        $data = $request->all();
        $accountCategory->update($data);

        return response()->json($accountCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountCategory  $accountCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountCategory $accountCategory)
    {
        $accountCategory->delete();

        return response()->json($accountCategory->id." has been successfully deleted.");
    }

    public function subCategory($id)
    {
        if($id == 0){
            $sub_categories = AccountCategory::where('parent_id', '=', null)->get();
        }else{
            $sub_categories = AccountCategory::where('parent_id', '=', $id)->get();
        }
        if($sub_categories){
            return response()->json($sub_categories);
        }
        return response()->json(null);
    }

    public function search($name)
    {
        $name = strtolower($name);
        $category = AccountCategory::query()
            ->where('name', 'LIKE', "%{$name}%")
            ->get();
        return response()->json($category);
    }
}
