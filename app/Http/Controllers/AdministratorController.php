<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{

    private function isAdministrator()
    {
        return in_array(Auth::id(), [1, 2]); // ID yang dianggap sebagai administrator
    }

    public function index()
    {
        $users = User::all();
        return view('admins.index', compact('users'));
    }

    public function create()
    {
        if (!$this->isAdministrator()) {
            return redirect()->route('admins.index')->with('error', 'Hanya Administrator yang bisa menambahkan user.');
        }

        return view('admins.create');
    }

    public function store(Request $request)
    {
        if (!$this->isAdministrator()) {
            return redirect()->route('admins.index')->with('error', 'Hanya Administrator yang bisa menambahkan user.');
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
        ]);

        return redirect()->route('admins.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $admin)
    {
        return view('admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        if (!$this->isAdministrator()) {
            return redirect()->route('admins.index')->with('error', 'Hanya Administrator yang bisa mengedit user.');
        }

        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        if (!$this->isAdministrator()) {
            return redirect()->route('admins.index')->with('error', 'Hanya Administrator yang bisa memperbarui user.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        if (!$this->isAdministrator()) {
            return redirect()->route('admins.index')->with('error', 'Hanya Administrator yang bisa menghapus user.');
        }

        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'User berhasil dihapus.');
    }
}
