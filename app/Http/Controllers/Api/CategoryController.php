<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = Category::all();
        foreach($categorys as $category){
            $data = [
                'name' => $category->name
            ];
        }
        return $this->indexResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $category = Category::create([
            'name' => $request->name
        ]);

        return $this->storeResponse($category->name);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with('subcategory')->find($id);
        if(!$category){
            return $this->notfoundResponse('Category Not Found');
        }
        foreach($category->subcategory as $subcategorys){
            $subcategory =[
                'Sub_Categoy_Name' => $subcategorys->name,
            ];
        }
        $data = [
            'name' => $category->name,
            'Sub_Category' => $subcategory
        ];

        return $this->showResponse($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
