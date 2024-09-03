<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Models\Book;
use App\Models\BorrowRecords;
use App\Models\User;
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
    public function store(Request $request)
    {
        //
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
            "status" => "success",
            'data' => [
                'book' => $data['book'],
                'borrowsRecords' => $data['borrowsRecords']
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
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
