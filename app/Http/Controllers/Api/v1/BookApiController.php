<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BulkStoreBookRequest;
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

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $req)
    {
        return  new BookCollection(Book::filter($req->query())->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $isAdmin = $request->user()->tokenCan("all");

        if ($isAdmin) {
            return new BookResource(Book::create($request->all()));
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }

    /**
     * Bulk store for books
     */

    public function bulkStore(BulkStoreBookRequest $request)
    {
        $bulk = collect($request->all());

        Book::insert($bulk->toArray());
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
        $isAdmin = $request->user()->tokenCan("all");

        if ($isAdmin) {
            $book->update($request->all());

            return new BookResource($book);
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book)
    {
        $isAdmin = $request->user()->tokenCan("all");
        if ($isAdmin) {
            $book->delete();
            return new BookResource($book);
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }
}
