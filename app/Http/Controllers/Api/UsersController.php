<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'remember_token' => str_random(10),
        ]);

        return $this->response->created();
    }
}
