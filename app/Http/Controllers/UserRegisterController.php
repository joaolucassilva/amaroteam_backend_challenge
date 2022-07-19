<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegister\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    public function __invoke(UserRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'name' => $request->get('name'),
        ]);

        if (empty($user)) {
            return response()->json(['error' => 'an error ocurred']);
        }

        return response()->json([], 201);
    }
}
