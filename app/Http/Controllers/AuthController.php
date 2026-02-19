<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin(){
        return view('login');
    }

    public function processLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->passes()){
            $credentials = [
                "email" => $request->email, 
                "password" => $request->password
                ];
            if(Auth::attempt($credentials)){
                return redirect()->route('dashboard.index');
            }else{
                return redirect()->route("auth.login")->with("error", "invalid passwrod or email");
            }
        }else{
            return redirect()->route('auth.login')->withInput()->withErrors($validator);
        }
    }

    public function showRegister(){
        return view('register');
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);
        if($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('auth.login')->with("success", "You are register successfull!");
        }else{
            return redirect()->route('auth.register')->withInput()->withErrors($validator);
        }
    }
}
