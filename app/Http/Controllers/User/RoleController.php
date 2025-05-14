<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $permissions = Permission::all();
        return view('modules.roles.index', compact('roles', 'permissions'));
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
            'name' => 'required|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        $role = Role::firstOrCreate([
            'name' => Str::slug($request->name),
            'description' => $request->description,
            'status' => 1, // default Active
        ]);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created and permissions assigned successfully.');
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
        $role = Role::findOrFail($id);

        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be edited.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Permissions Update
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Cannot change status of Super Admin role.');
        }

        $role->status = !$role->status;
        $role->save();

        return redirect()->back()->with('success', 'Role status updated!');
    }

    public function assignPermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all(); // Get all permissions
        return view('modules.roles.permissions', compact('role', 'permissions'));
    }

    public function syncPermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        // Sync permissions
        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.permissions', $role->id)->with('success', 'Permissions updated successfully!');
    }

    public function removePermission($roleId, $permissionId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($permissionId);

        // Remove permission from role
        $role->revokePermissionTo($permission);

        return redirect()->route('roles.permissions.assigned', $role->id)->with('success', 'Permission removed successfully!');
    }
}
