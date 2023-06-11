<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Traits\HandleApi;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookImage;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use HandleApi;

    public function index()
    {
        return self::sendResponse(Book::all(), 'All Books are fetched');
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

        if ($data['categories']) {
            foreach ($data['categories'] as $category) {
                BookCategory::create([
                    'category_id' => $category,
                    'book_id' => $book->id
                ]);
            }
        }

        if ($data['images']) {
            foreach ($data['images'] as $image) {
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
        return self::sendResponse([
            'book' => Book::findOrFail($id)->first(),
            'images' => Book::findOrFail($id)->images
        ], 'Book data is fetched successfully');
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validated();
        $book->update($data);
        return response()->json(['message' => 'Book updated successfully']);
    }



    public function download(Request $request, Book $book)
    {
        $isTeacherResource = $request->is('api/subcategories/*/books/download');

        if ($isTeacherResource) {
            $serialCode = $request->input('serial_code');

            if ($serialCode === $book->serial_code) {
                return response()->json([
                    'download_link' => $book->pdf_path
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid serial code.'
                ], 403);
            }
        } else {
            $phone = $request->input('phone');
            $studentForm = TeacherForm::where('phone', $phone)->first();

            if ($studentForm) {
                return response()->json([
                    'download_link' => $book->pdf_path
                ]);
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'position' => 'required',
                ]);

                $studentForm = TeacherForm::create($validatedData);

                return response()->json([
                    'message' => 'Please fill out the form.',
                    'form_id' => $studentForm->id
                ]);
            }
        }
    }

    public function destroy(string $id)
    {

    }
}
