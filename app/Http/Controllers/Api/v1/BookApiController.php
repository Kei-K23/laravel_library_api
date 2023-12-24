<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreBookRequest;
use App\Http\Requests\v1\UpdateBookRequest;
use App\Http\Resources\v1\BookCollection;
use App\Http\Resources\v1\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        return  new BookCollection(Book::filter($req->query())->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        return new BookResource(Book::create($request->all()));
    }

    /**
     * Bulk store for books
     */

    public function bulkStore()
    {
    }


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
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
}
