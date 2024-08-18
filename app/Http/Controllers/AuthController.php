<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(){

        if(!Auth::check()){

            return view('auth.login');
        }
    
        return redirect()->route('home');
    }

    public function authenticate(LoginRequest $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
           
            $request->session()->regenerate();

            return redirect()->route('home');
        }
    }

    public function register(){

        if(!Auth::check()){

            return view('auth.register');
        }

        return redirect()->route('home');
    }

    public function store(RegisterRequest $request){

        User::create($request->all());
    }

    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }   
}
