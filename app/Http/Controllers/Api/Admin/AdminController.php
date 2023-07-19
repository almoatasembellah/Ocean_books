<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use App\Http\Traits\HandleApi;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    use HandleApi;
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Admin Token', ['*']);
            // Check if the user has the 'admin' role
            if ($user->hasRole('admin')) {
                $data['token'] =  $user->createToken('Roqya')->plainTextToken;

                $data['name'] =  $user->name;

                return $this->sendResponse($data, 'You logged in successfully.');


            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
