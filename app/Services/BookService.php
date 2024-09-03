<?php

namespace App\Services;

use App\Http\Resources\BookResource;
use App\Http\Resources\BorrowRecordsResource;
use App\Models\Book;
use App\Models\BorrowRecords;

class  BookService
{
    /**
     * show all  book
     * @param string $author  
     * @param string $title  
     * @param string $category  
     * @param int $numberOfBooks  
     * @return BookResource books 
     */
    public function allBooks($author, $title, $category, $numberOfBooks)
    {
        $books = Book::query();
        $books = $books
            ->byAuthor($author)
            ->byTitle($title)
            ->byCategory($category)
            ->paginate($numberOfBooks);
        $books = BookResource::collection($books);
        return  $books;
    }
    /**
     * show a  book
     * @param  $book  
     * @return BookResource book  
     */
    public function oneBook($book)
    {
        $data['book'] = BookResource::make($book);

        $borrowsRecords = BorrowRecords::where('book_id', '=', $book->id)->get();

        $data['borrowsRecords'] = BorrowRecordsResource::collection($borrowsRecords);

        return $data;
    }
    /**
     * create a  new book
     * @param  $request  
     * @return BookResource book  
     */
    public function createBook($request)
    {
        $bookData = $request->all();
        if ($request->hasFile('image')) {
            $bookData['image'] = $request->file('image')->store('imagesBooks', 'public');
        }

        $book = Book::create($bookData);
        $book  = BookResource::make($book);
        return  $book;
    }
    /**
     * update a  book
     * @param Book $book  
     * @param  $request  
     * @return BookResource book  
     */
    public function updateBook(Book $book, $request)
    {
        $bookData = $request->all();
        if ($request->hasFile('image')) {
            $bookData['image'] = $request->file('image')->store('imagesBooks', 'public');
        }
        $book->update($bookData);
        $book = Book::find($book->id);
        $book = BookResource::make($book);
        return  $book;
    }

    /**
     * delete a  book
     * @param Book $book  
     */
    public function deleteBook(Book $book)
    {
        $book->delete();
    }

    /**
     * all categories
     * @return string categories  
     */
    public function allCategory()
    {
        $categories = Book::select('category')->distinct()->get();
        $x = [];
        foreach ($categories  as $i) {
            array_push($x, $i->category);
        }
        $categories = $x;
        return $categories;
    }
}
