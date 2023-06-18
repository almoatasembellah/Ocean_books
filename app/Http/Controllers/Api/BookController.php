<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Traits\HandleApi;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(BookResource::collection(Book::paginate(25)), 'All Books are fetched');
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $pdfPath = $request->file('pdf')->store('book-pdfs', 'public');
        $coverPath = $request->file('cover_image')->store('book-covers', 'public');
        $data['pdf_path'] = $pdfPath;
        $data['cover_image'] = $coverPath;
        $data['serial_code'] = \Str::uuid();
        $book = Book::create($data);

        if ($request->has('categories')) {
            foreach ($request->get('categories') as $category) {
                BookCategory::create([
                    'category_id' => $category,
                    'book_id' => $book->id
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('book-images', 'public');
                BookImage::create([
                    'path' => $imagePath,
                    'book_id' => $book->id
                ]);
            }
        }
        return self::sendResponse([], 'Book is created successfully');
    }

    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return $this->sendResponse(BookResource::make($book), 'Book data is fetched successfully');
    }


    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validated();
        $book->update($request->validated());
        return $this->sendResponse([], "Book updated successfully");
    }


    public function download(Request $request)
    {
        $book = Book::findOrFail($request->get('book_id'));
        $isTeacher = $book->categories()->whereBookHeaderId(4)->exists();
        if ($isTeacher) {
            $this->validate(request(), [
                'serial_code' => 'required|string',
            ]);

            $serialCode = request('serial_code');

            if ($serialCode !== $book->serial_code) {
                return response()->json(['error' => 'Invalid serial code'], 403);
            }
        } else {
            $this->validate(request(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'position' => 'required|string',
            ]);

            $phone = request('phone');

            if (!User::where('phone', $phone)->exists()) {
                User::create(request()->only(['name', 'email', 'phone', 'position']));
            }
        }
        return response()->download(storage_path('app/public/' . $book->pdf_path), $book->title . '.pdf');
    }

//    public function serialCheck(Request $request)
//        {
//            $checkins = Checkin::whereDate('created_at', Carbon::today())->get();
//
//    }

    public function destroy($id)
    {
         Book::findOrFail($id)->delete();
        return $this->Sendresponse([], 'Book has been deleted successfully');
    }
}
