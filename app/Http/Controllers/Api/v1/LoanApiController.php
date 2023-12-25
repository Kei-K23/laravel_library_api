<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckTokenAbility;
use App\Http\Requests\v1\StoreLoanRequest;
use App\Http\Requests\v1\UpdateLoanRequest;
use App\Http\Resources\v1\LoanCollection;
use App\Http\Resources\v1\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;

class LoanApiController extends Controller
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

        $loansQuery =  Loan::filter($req->query());

        if ($req->query('includeBookAndUser')) {
            $loansQuery = $loansQuery->with(['book', 'user']);
        } elseif ($req->query('includeUser')) {
            $loansQuery = $loansQuery->with('user');
        }

        $loans = $loansQuery->paginate();

        return new LoanCollection($loans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {

        $book = Book::where('id', $request->input('bookId'))->first();

        if ($book->availability_status === "AVAILABLE") {
            $book->availability_status = "LOANED";
            $book->save();

            return new LoanResource(Loan::create($request->all()));
        } else {
            return response(['error' => $book->id . " is already loaned! Cannot be loan!"], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req, Loan $loan)
    {
        if ($req->query('includeBookAndUser')) {
            return new LoanResource($loan->loadMissing('user'));
        }

        return new LoanResource($loan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        if ($request->input('status') === "RETURNED") {
            $book = Book::where('id', $request->input("bookId"))->first();

            if ($book->availability_status === "LOANED") {
                $book->availability_status = "AVAILABLE";
                $book->save();
                $loan->update($request->all());
                return new LoanResource($loan);
            }
        }

        if ($request->input('status') === "LOANED") {
            $loan->update($request->all());

            return new LoanResource($loan);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Loan $loan)
    {
        $isAdmin = $request->user()->tokenCan("all");
        if ($isAdmin) {
            $loan->delete();
            return new LoanResource($loan);
        } else {
            return response(['error' => 'unauthorized'], 401);
        }
    }
}
