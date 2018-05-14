<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|min:6|max:50',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);
        if($user){
            Auth::login($user);
            session()->flash('success', 'Welcome, Now you can do anything you want~');
            return redirect()->route('users.show', [$user]);
        }else{
            session()->flash('errors', 'Oops, sign up again~');
            return redirect()->route('signup');
        }

    }
}
