<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login()
    {
        return "Welcome to Log into Dashboard";
    }

    public function submit(AdminLoginRequest $request)
    {
        if (auth('admin')->attempt(['email' => $request->get('email'),'password'=>$request->get('password')])){
            return "Welcome to Dashboard";
        }
        return redirect()->back()->withInput($request->only('email','remember'))->withErrors(['Credentials Doesn\'t match' ]);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        return "redirect()->route('admin.login')";
    }

}
