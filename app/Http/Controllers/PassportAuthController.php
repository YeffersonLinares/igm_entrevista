<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PassportAuthController extends Controller
{

    public function login_view()
    {
        if (empty(Auth::user())) {
            return Inertia::render('Login');
        } else {
            return redirect('/facturas');
        }
    }

    public function index()
    {
        return redirect('/login');
    }

    public function login(Request $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!empty(Auth::user())) {
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 422,
            ]);
        }
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function is_log()
    {
        return Auth::user();
    }
}
