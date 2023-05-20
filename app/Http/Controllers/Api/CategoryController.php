<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::included()->filter()->sort()->get();
        //return $categories;  lo cambiamos por el CategoryResource
        return CategoryResource::collection($categories);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories',
        ]);

        $category = Category::create($request->all());

        return $category;
        //return CategoryResource::make($category);
    }


    public function show($id)
    {
        $category = Category::included()->findOrFail($id);
        //return $category;
        //return CategoryResource::make($category);
        return New CategoryResource($category);
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' .$category->id,
        ]);

        $category->update($request->all());

        return $category;
    }


    public function destroy(Category $category)
    {
        $category->delete();
    }
}
