<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreUserRequest;
use App\Http\Requests\v1\UpdateUserRequest;
use App\Http\Resources\v1\UserCollection;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;


class UserApiController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        return new UserCollection(User::filter($req->query())->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $user->save();
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    // create token for authorization for member and admin
    public function tokenCreate(Request $req)
    {
        $req->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        $user = User::where('email', $req->input('email'))->first();

        if ($user) {
            if (password_verify($req->input('password'), $user->password)) {
                if ($user->account === "Member") {
                    $token =   $user->createToken('member', ['read', 'loan'])->plainTextToken;
                    return response(['memberToken' => $token]);
                }
                if ($user->account === "Admin") {
                    $token =   $user->createToken('admin', ['all'])->plainTextToken;
                    return response(['adminToken' => $token]);
                }
            }
        }

        return response([
            'error' => 'Invalid user!'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
