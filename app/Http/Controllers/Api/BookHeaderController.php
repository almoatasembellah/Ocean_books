<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookHeaderRequest;
use App\Http\Traits\HandleApi;
use App\Models\BookHeader;

class BookHeaderController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(BookHeader::select('title')->get() , 'All Book headers are fetched');
    }


    public function store(BookHeaderRequest $request)
    {
        BookHeader::create($request->validated());
        return self::sendResponse([] , 'Header is added successfully');
    }

    public function show($id)
    {
        return self::sendResponse(BookHeader::findOrFail($id)->first('title') , 'Book headers is fetched');

    }

    public function update(BookHeaderRequest $request, $id)
    {
            $header = BookHeader::findOrFail($id);
            $header->update($request->validated());
            return self::sendResponse([] , 'Header is updated successfully');
    }

    public function destroy($id)
    {
        $header = BookHeader::findOrFail($id);
        $header->delete();
        return self::sendResponse([] , 'Header is deleted successfully');
    }
}
