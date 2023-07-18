<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookHeaderRequest;
use App\Http\Traits\HandleApi;
use App\Models\BookHeader;
use Illuminate\Support\Facades\Request;

class BookHeaderController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(BookHeader::select(['id', 'title'])->get(), 'All Book headers are fetched');
    }


    public function store(BookHeaderRequest $request)
    {
        BookHeader::create($request->validated());
        return self::sendResponse([] , 'Header is added successfully');
    }

    public function show(Request $request, $id)
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

    public function destroy($id)
    {
        $header = BookHeader::findOrFail($id);
        $header->delete();
        return self::sendResponse([] , 'Header is deleted successfully');
    }
}
