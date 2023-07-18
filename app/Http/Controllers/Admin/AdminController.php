<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = Auth::user();

            if ($user->is_admin) {
                $token = $user->createToken('adminToken')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'email' => ['Invalid credentials or you are not an administrator.'],
        ]);
    }
}
