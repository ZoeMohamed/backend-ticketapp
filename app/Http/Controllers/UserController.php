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

    public function update(Request $request, User $user)
    {


        // wrong way to do mass update
        // $user->update($request->all());
        $input = $request->all();
        $user->fill($input)->save();


        // check if password is not empty
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // check if phone is not empty
        if ($request->phone) {
            $user->update([
                'phone' => $request->phone
            ]);
        }


        return redirect()->route('users.index')->with('success', 'User Updated Successuflly');
    }
}
