<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return $categories;
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
        return $category;
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
