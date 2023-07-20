<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Traits\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    use HandleApi;

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                $token = $user->createToken('Roqya')->plainTextToken;
                return $this->sendResponse(['token' => $token, 'name' => $user->name],'Admin Logged In Successfully');
            } else {
                return $this->sendError('error', 'Unauthorized from login function');
            }
        } else {
            return $this->sendError('error', 'Invalid credentials');
        }
    }



        public function adminLogout(Request $request)
            {
                $request->user()->tokens()->delete();
                return $this->sendResponse([], 'You have been logged out successfully.');
            }

}
