<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Show all roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return Inertia::render('role/index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the create role form.
     */
    public function create()
    {
        return Inertia::render('role/create', [
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store new role with permissions.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        $permissionIds = $request->permissions ?? [];
        $role->permissions()->sync($permissionIds);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    /**
    * Show the a role.
     */
    
    public function show($id)
    {
        //
    }
    /**
     * Show the edit form for a role.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        return Inertia::render('role/edit', [
            'role' => $role,
            'permissions' => Permission::all(),
            'rolePermissions' => $role->permissions->pluck('id'),
        ]);
    }

    /**
     * Update the role and its permissions.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($id)],
            'permissions' => 'nullable|array',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        $permissionIds = $request->permissions ?? [];
        $role->permissions()->sync($permissionIds);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role (except protected ones).
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting critical roles
        if (in_array($role->name, ['Admin'])) {
            return redirect()->back()->with('error', 'Cannot delete default role: ' . $role->name);
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role removed successfully.');
    }
}
