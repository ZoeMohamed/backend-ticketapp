<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $users = DB::table('users')->when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('email', 'like', "%{$request->keyword}%")
                ->orWhere('email', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required',
            'role' => 'required'
        ]);

        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User Created Successuflly');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function udpate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|string',
            'phone' => 'required',
            'role' => 'required'
        ]);

        // check if password is not empty
        if ($request->password) {
            $request->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User Updated Successuflly');
    }
}
