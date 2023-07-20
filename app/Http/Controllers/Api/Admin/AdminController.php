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
                return $this->sendError('Error', 'Unauthorized pal');
            }
        } else {
            return $this->sendError('error' , 'Unauthorized');
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->sendResponse([], 'You have been logged out successfully.');
    }

}
