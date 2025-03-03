<?php

namespace App\Http\Controllers;


use App\Models\User;


class AdminController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }


    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function user($id)
    {
        $user = User::find($id);
        return view('admin.user', compact('user'));
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users');
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.editUser', compact('user'));
    }

    public function updateUser($id)
    {
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->save();
        return redirect()->route('admin.users');
    }

}