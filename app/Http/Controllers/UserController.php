<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request, CreateNewUser $creator)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:administrador,cliente',
        ]);

        $creator->create($request->all());

        return redirect()->route('users.index')->with('success', __('User created successfully.'));
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
