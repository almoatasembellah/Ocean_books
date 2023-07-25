<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookHeaderRequest;
use App\Http\Resources\BookHeaderResource;
use App\Http\Traits\HandleApi;
use App\Models\BookHeader;
use Illuminate\Http\Request;

class BookHeaderController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(BookHeader::select(['id', 'title'])->get(), 'All Book headers are fetched');
    }

    public function bookHeadersToUser()
    {
        $bookHeaders = BookHeader::with('categories')->get();
        return $this->sendResponse(BookHeaderResource::collection($bookHeaders), 'All Book headers are fetched for user');
    }


    public function store(BookHeaderRequest $request)
    {
        BookHeader::create($request->validated());
        return self::sendResponse([] , 'Header is added successfully');
    }

    public function show($id)
    {
        $header = BookHeader::findOrFail($id);
        return self::sendResponse([$header->title], 'Requested book header is fetched');
    }

    public function update(BookHeaderRequest $request, $id)
    {
            $header = BookHeader::findOrFail($id);
            $header->update($request->validated());
            return self::sendResponse([] , 'Header is updated successfully');
    }

    public function getBooksByHeaderID(Request $request)
    {
        $bookHeaderId = $request->input('book_header_id');
        $bookHeader = BookHeader::find($bookHeaderId);

        if (!$bookHeader) {
            return $this->sendError('Book Header not found.', [], 404);
        }

        // Get all categories and books related to the specified Book Header
        $categories = $bookHeader->categories;
        $books = $bookHeader->books;

        return $this->sendResponse([
            'book_header' => $bookHeader,
            'categories' => $categories,
            'books' => $books
        ], 'Categories and Books for the specified Book Header are fetched successfully.');
    }



    public function destroy($id)
    {
        $header = BookHeader::findOrFail($id);
        $header->delete();
        return self::sendResponse([] , 'Header is deleted successfully');
    }
}
