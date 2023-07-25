<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\HandleApi;
use App\Models\Category;
use File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HandleApi;

    public function index()
    {

        return self::sendResponse(CategoryResource::collection(Category::paginate(25)), 'All Categories are fetched');

    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('categories-covers', 'public');
            $data['cover'] = asset('storage/' . $coverPath); // Get the full URL for the image
        }
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('book-pdfs', 'public');
            $data['pdf_path'] = asset('storage/' . $pdfPath); // Get the full URL for the PDF
        }
        $category = Category::create($data);

        return self::sendResponse(CategoryResource::make($category), 'Category added successfully');
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

    public function getBooksByCategoryId(Request $request)
    {
        $categoryId = $request->input('category_id');

        $category = Category::find($categoryId);
        if (!$category) {
            return self::sendError('Category not found.', [], 404);
        }
        $books = $category->books;
        return self::sendResponse(BookResource::collection($books), 'Books related to the category are fetched successfully.');
    }


    public function destroy(Category $category)
    {
        File::delete(storage_path('app/public'."/".$category->cover));
        $category->delete();
        return self::sendResponse([], 'Category is deleted Successfully');
    }
}
