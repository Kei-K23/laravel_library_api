<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreAuthorRequest;
use App\Http\Requests\v1\UpdateAuthorRequest;
use App\Http\Resources\v1\AuthorResource;
use App\Http\Resources\v1\AuthorCollection;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $authorsQuery = Author::filter($req->query());
        if ($req->query('includeBooks')) {
            $authorsQuery = $authorsQuery->with('books');
        }

        $authors = $authorsQuery->paginate();

        return new AuthorCollection($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        return new AuthorResource(Author::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author, Request $req)
    {
        // include books
        if ($req->query('includeBooks')) {
            return new AuthorResource($author->loadMissing('books'));
        }

        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
