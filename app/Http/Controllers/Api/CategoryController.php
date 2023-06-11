<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Traits\HandleApi;
use App\Models\Category;
use File;

class CategoryController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(Category::all(), 'All Categories are fetched');

    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->file('cover')) {
            $coverPath = $request->file('cover')->store('categories-covers', 'public');
            $data['cover'] = $coverPath;
        }
        Category::create($data);
        return self::sendResponse([], 'Category added successfully');
    }

    public function show($id)
    {
        return self::sendResponse(Category::findOrFail($id)->first('name'), 'Category is fetched');
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        if ($request->file('cover')) {
            File::delete(storage_path('app/public'."/".$category->cover));
            $coverPath = $request->file('cover')->store('categories-covers', 'public');
            $data['cover'] = $coverPath;
        }
        $category->update($data);
        return self::sendResponse([], 'Category is updated successfully');
    }

    public function destroy(Category $category)
    {
        File::delete(storage_path('app/public'."/".$category->cover));
        $category->delete();
        return self::sendResponse([], 'Category is deleted Successfully');
    }
}
