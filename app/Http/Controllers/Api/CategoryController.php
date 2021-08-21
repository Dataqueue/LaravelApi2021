<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkSubcategories($id)
    {
        $groupedCategories = Category::all()->groupBy('parent_id');
        // dd($groupedCategories[0]);
        if ($groupedCategories->has($id)) {
            $temp = $groupedCategories[$id];
                $temp->map(
                    function ($category) {
                        return $category;
                            // 'category' => $category,
                            // 'sub_categories' => $this->checkSubcategories($category->id)
                    }
                );
            return $temp;
        }
        return $this->subCategory($id);
    }

    public function categories()
    {
        $categories = Category::where('parent_id', '=', null)->get();
        $data = [
            // $categories,
            $categories->map(function ($category) {
                return [
                    'category' => $category,
                    'sub_categories' => $this->checkSubcategories($category->id),
                    // 'sub_categories' => $this->subCategory($category->id),
                ];
            }),
        ];

        return response()->json($data[0]);
    }



    public function index()
    {
        $categories = Category::where('parent_id', '=', null)->get();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required',
            'description' => 'required',
        ];

        $messages = ['required' => 'The :attribute field is required.'];

        $validator = Validator::make($request->all(), $rule, $messages);
        $errors = $validator->errors();
        foreach ($errors as $error) {
            echo $error;
        }

        $category = new Category;

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->save();

        return response()->json($category, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rule = [
            'name' => 'required',
            'description' => 'required',
        ];

        $messages = ['required' => 'The :attribute field is required.'];

        $validator = Validator::make($request->all(), $rule, $messages);
        $errors = $validator->errors();
        foreach ($errors as $error) {
            echo $error;
        }


        $category->update($request->all());

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $res = $category->delete();
        if ($res) {
            return (['msg' => 'category' . ' ' . $category->id . ' is successfully deleted']);
        }
    }

    public function products_in_category()
    {
        $cat = DB::table('categories')
            ->leftJoin(
                'products',
                'categories.id',
                '=',
                'products.category_id'
            )
            ->select(['categories.*', 'products.category_id'])
            ->get();
        $grouped = $cat->groupBy('category_id');
        $data = array();
        foreach ($grouped as $group) {
            // dd($group);
            // array_push($data,[
            //     'id' => $group[0]->id,
            //     'name' => $group[0]->name,
            //     'description' => $group[0]->description,
            //     'products' =>count($group),
            //     ]
            // );
            if ($group[0]->category_id == null) {
                foreach ($group as $item) {
                    array_push($data, [
                        'id' => $item->id,
                        'name' => $item->name,
                        'description' => $item->description,
                        'products' => 0,
                    ]);
                }
            } else {
                array_push($data, [
                    'id' => $group[0]->id,
                    'name' => $group[0]->name,
                    'description' => $group[0]->description,
                    'products' => count($group),
                ]);
            };
        }

        return response()->json($data);
    }

    public function categorized_products($id)
    {
        $products = Product::where('category_id', '=', $id)->get();
        $data = $products->map(function ($product) {

            $product_data = DB::table('products')
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->leftJoin('divisions', 'divisions.id', '=', 'products.division_id')
                ->select('products.*', 'categories.name as category_name', 'divisions.name as division_name')
                ->where('products.id', '=', $product->id)
                ->first();
            return ($product_data);
        });

        return response()->json($data, 200);
    }

    public function subCategory($id)
    {

        $sub_categories = Category::where('parent_id', '=', $id)->get();
        return response()->json($sub_categories);
    }

    public function search($name)
    {
        $name = strtolower($name);
        // $category = Category::whereLike('name', $name)->get();
        $category = Category::query()
            ->where('name', 'LIKE', "%{$name}%")
            ->get();
        return response()->json($category);
    }
}
