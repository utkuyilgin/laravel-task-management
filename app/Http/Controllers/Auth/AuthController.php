<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController
{
  
    public function login()
    {
        return view('admin.auth.index');
    }
    
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Wrong email or password');
        }

        if (auth()->attempt($credentials)) {
            

            return redirect()->route('admin.dashboard')->with('success', 'Successfully logged in');
        } else {
            
            return redirect()->back()->with('error', 'Wrong email or password');
        }
    }
    public function logout()
    {
        //logout guard for restaurant
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
