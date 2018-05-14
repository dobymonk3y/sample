<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        /*
         * Auth::attempt(['email' => $email, 'password' => $password])
         * attempt 方法会接收一个数组来作为第一个参数，该参数提供的值将用于寻找数据库中的用户数据
         */
        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash('success', 'Welcome back！');
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            session()->flash('danger', 'Sorry, your email or password do not match!');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','You have successfully exited!');
        return redirect()->route('home');
    }
}
