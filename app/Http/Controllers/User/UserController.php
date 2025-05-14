<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get(); // roles = Spatie relationship
        $roles = Role::all();
        return view('modules.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,id',
            'status' => 'required|in:0,1',
            ]);

            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            ]);

            $user->assignRole(Role::find($request->role)->name);

            return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|exists:roles,id',
        'status' => 'required|in:0,1',
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->status = $request->status;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Update Role
    $user->syncRoles([Role::find($request->role)->name]);

    return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Super Admin ডিলিট থেকে রক্ষা
        if ($user->hasRole('Super Admin')) {
            return redirect()->back()->with('error', 'Super Admin cannot be deleted!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        // Check if the user is Super Admin
        if ($user->hasRole('Super Admin')) {
            return redirect()->back()->with('error', 'Super Admin status cannot be inactive.');
        }
        $user->status = !$user->status; // toggle: 1 -> 0, 0 -> 1
        $user->save();

        return redirect()->route('users.index')->with('success', 'User status updated!');
    }
}
