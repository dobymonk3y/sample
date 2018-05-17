<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            # 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制。
            # 相反的还有 only 白名单方法，将只过滤指定动作
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest',[
            'only' =>['create']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            session()->flash('danger', 'Oops, sign up again~');
            return redirect()->route('signup');
        }

    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        # $this->authorize('update',$user);
        try {
            $this->authorize ('update', $user);
            return view ('users.edit', compact ('user'));
        } catch (\Exception $e) {
            #abort(500, $e->getMessage());
            abort(500, $e->getMessage());
        }
        return view('users.edit', compact('user'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(User $user,Request $request)
    {
        # $this->authorize('update',$user);
        try {
            $this->authorize ('update', $user);
            return view ('users.edit', compact ('user'));
        } catch (\Exception $e) {
            #abort(500, $e->getMessage());
            abort(500, $e->getMessage());
        }
        $this->validate($request,[
            'name'      => 'required|min:6|max:50',
            # 'password'  => 'required|confirmed|min:6' 必须填写
            'password'  => 'nullable|confirmed|min:6'   # 可以为空
        ]);

        /*$result = $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);*/

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $result = $user->update($data);

        if($result){
            session()->flash('success','Information update successfully !');
            return redirect()->route('users.show', $user->id);
        }else{
            session()->flash('danger','Oops, there is something wrong, please try again later!');
            return redirect()->back();
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'User has been deleted successfully!');
        return back();
    }
}
