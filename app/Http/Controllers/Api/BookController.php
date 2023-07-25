<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\SerialResource;
use App\Http\Traits\HandleApi;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookImage;
use App\Models\Category;
use App\Models\Serial;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use HandleApi;

    public function index()
    {
        $user = request()->user();
        if ($user->hasRole('admin')) {
            return self::sendResponse(BookResource::collection(Book::paginate(25)), 'All Books are fetched');
        }
    }

    //books for user
    public function getAllBooksForUsers()
    {
        $books = Book::paginate(25);
        return BookResource::collection($books);
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);

        if (!$category) {
            return self::sendError('Category not found.', [], 404);
        }

        // Store the files
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('book-pdfs', 'public');
            $data['pdf_path'] = asset('storage/' . $pdfPath); // Get the full URL for the PDF
        }

        $coverPath = $request->file('cover_image')->store('book-covers', 'public');
        $videoPath = $request->file('video')->store('book-videos', 'public');
        $data['video'] = asset('storage/' . $videoPath); // Get the full URL for the video
        $data['cover_image'] = asset('storage/' . $coverPath); // Get the full URL for the cover image
        $data['serial_code'] = \Str::uuid();


        $book = Book::create($data);
        // Now, create the BookCategory record using the existing category_id
        BookCategory::create([
            'category_id' => $category->id,
            'book_id' => $book->id
        ]);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('book-images', 'public');
                BookImage::create([
                    'path' => asset('storage/' . $imagePath), // Get the full URL for the image
                    'book_id' => $book->id
                ]);
            }
        }

        return self::sendResponse(BookResource::make($book), 'Book is created successfully');
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
        $book->update($data);
        return $this->sendResponse([], "Book updated successfully");
    }


    public function downloadBook(Request $request)
    {
        $book = Book::findOrFail($request->get('book_id'));
        $isTeacher = $book->categories()->whereBookHeaderId(4)->exists();
        if ($isTeacher) {
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

        else {
            $check = Serial::where('material_code', $request->input('material_code'))->firstOrFail();
            $this->validate(request(), [
                'material_code' => 'required|string',
            ]);

            $serialCode = request('material_code');

            if ($serialCode !== $check->material_code) {

                return $this->sendError('Serial Error','Invalid Serial Code, Try another one.');

            }
        }
        return response()->download(storage_path('app/public/' . $book->pdf_path), $book->title . '.pdf');
    }

    public function downloadVideo(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $check = Serial::where('material_code', $request->input('material_code'))->firstOrFail();

        $this->validate($request, [
            'material_code' => 'required|string',
        ]);

        $materialCode = $request->input('material_code');

        if ($materialCode !== $check->material_code) {
            return $this->sendError('Serial Error', 'Invalid Serial Code, please try again.');
        }

        return $this->sendResponse(['video_url' => $book->video_url], 'URL is ready!');
    }


    //Serial Code Generation and Fetching them
    public function generateSerialCodes(Request $request)
    {
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity');
//        $book = Book::findOrFail($bookId);
        $serialCodes = [];

        for ($i = 0; $i < $quantity; $i++) {
            $serialCode = $this->generateUniqueSerialCode();

            // Associate serial code with the book
            $serialCodes[] = [
                'book_id' => $bookId,
                'material_code' => $serialCode
            ];
        }

        // Insert serial codes into the database
        Serial::insert($serialCodes);

        // Return the generated serial codes
        return response()->json($serialCodes);
    }


    private function generateUniqueSerialCode()
    {
        do {
//            $serialCode = Str::random(10);
            $serialCode = random_int(100000000,999999999);
        } while (Serial::where('material_code', $serialCode)->exists());
        return $serialCode;
    }

    public function generatedCodes()
    {
        return self::sendResponse(SerialResource::collection(Serial::paginate(25)),'all Serials are fetched.');
    }

    public function destroy($id)
    {
         Book::findOrFail($id)->delete();
        return $this->Sendresponse([], 'Book has been deleted successfully');
    }
}
