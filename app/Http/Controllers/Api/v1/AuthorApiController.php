<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreAuthorRequest;
use App\Http\Requests\v1\UpdateAuthorRequest;
use App\Http\Resources\v1\AuthorResource;
use App\Http\Resources\v1\AuthorCollection;
use App\Models\Author;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;

class AuthorApiController extends Controller
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
        $isAdmin = $request->user()->tokenCan("all");

        if ($isAdmin) {
            return new AuthorResource(Author::create($request->all()));
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
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
        $isAdmin = $request->user()->tokenCan("all");

        if ($isAdmin) {
            $author->update($request->all());
            return new  AuthorResource($author);
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Author $author)
    {
        $isAdmin = $request->user()->tokenCan("all");
        if ($isAdmin) {
            $author->delete();
            return new AuthorResource($author);
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }
}
