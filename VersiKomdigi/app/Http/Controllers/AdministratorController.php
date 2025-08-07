<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'administrator')->get(); // Hanya Administrator
        return view('admins.index', compact('users'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        // Pastikan hanya super-admin yang bisa menambahkan administrator
        if (Auth::user()->role !== 'super-admin') {
            return redirect()->route('admins.index')->with('error', 'Hanya Super-Admin yang bisa menambahkan Administrator.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'administrator',
        ]);

        return redirect()->route('admins.index')->with('success', 'Administrator berhasil ditambahkan.');
    }



    public function show(User $user)
    {
        return view('admins.show', compact('user'));
    }

    public function edit(User $admin)
    {
        if (Auth::user()->role !== 'super-admin') {
            return redirect()->route('admins.index')->with('error', 'Hanya Super-Admin yang bisa mengedit Administrator.');
        }

        return view('admins.edit', compact('admin'));
    }


    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'super-admin') {
            return redirect()->route('admins.index')->with('error', 'Hanya Super-Admin yang bisa mengubah Administrator.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admins.index')->with('success', 'Administrator berhasil diperbarui.');
    }


    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'super-admin') {
            return redirect()->route('admins.index')->with('error', 'Hanya Super-Admin yang bisa menghapus Administrator.');
        }

        $user->delete();
        return redirect()->route('admins.index')->with('success', 'Administrator berhasil dihapus.');
    }

}
