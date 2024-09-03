<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * show all movie
     *
     * @param Request $request 
     *
     * @return response a list of books
     */
    public function index(Request $request)
    {
        $author = $request->input('author');
        $category = $request->input('category');
        $title = $request->input('title');
        $numberOfBooks = $request->input('numberOfBooks');
        $books = $this->bookService->allBooks($author, $title, $category, $numberOfBooks);

        return  $books;
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     *  create a new  book
     *
     * @param StoreBookRequest $request 
     *
     * @return response  of the status of operation : message and the new book
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->createBook($request);

        return response()->json([
            'status' => 'success',
            "message" => 'تم اضافة الكتاب بنجاح',
            'data' => [
                'book' => $book
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */

    /**
     *  show a specific  movie
     *
     * @param Book $book 
     *
     * @return response  of the status of operation and book
     */
    public function show(Book $book)
    {
        $data = $this->bookService->oneBook($book);
        return response()->json([
            'status' => 'success',
            'data' => [
                'book' => $data['book']
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     *  update a specific  movie
     *
     * @param Book $book 
     * @param UpdateBookRequest $request 
     * @return response  of the status of operation : message  and the book
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book = $this->bookService->updateBook($book, $request);
        return response()->json([
            'status' => 'success',
            "message" => 'تم تحديث الكتاب بنجاح',
            'data' => [
                'book' => $book
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     *  remove a specific  movie
     *
     * @param Book $book 
     *
     * @return response  of the status of operation : message 
     */
    public function destroy(Book $book)
    {
        $this->bookService->deleteBook($book);
        return response()->json([
            'status' => 'success',
            "message" => 'تم الحذف بنجاح',
        ], 204);
    }
    /**
     *  show all category 
     *
     *
     * @return response  of the status of operation :  categories
     */
    public function allCategory()
    {
        $categories = $this->bookService->allCategory();
        return response()->json([
            'status' => 'success',
            'data' => [
                'categories' => $categories
            ]
        ], 200);
    }
}