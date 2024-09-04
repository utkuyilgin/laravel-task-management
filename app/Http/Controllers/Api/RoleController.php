<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\RoleRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function fetchRoles()
    {
        $roles = $this->roleRepository->all();
        return response()->json(['data' => $roles], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = $this->roleRepository->create(['name' => $request->input('name')]);
        $permissions = Permission::whereIn('id', $request->permission)->get();

        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Role created successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = $this->roleRepository->update($request->id, ['name' => $request->input('name')]);
        $permissions = Permission::whereIn('id', $request->permission)->get();

        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        $this->roleRepository->delete($id);
        return response()->json(['message' => 'Role deleted']);
    }
}
