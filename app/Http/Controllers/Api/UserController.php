<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $users =  User::when($request->name, function ($q) {
            $q->where('name', 'LIKE', '%' . request()->name . '%');
        })->orderBy('name', 'ASC')->paginate(20);

        return UserResource::collection($users);
    }
}
