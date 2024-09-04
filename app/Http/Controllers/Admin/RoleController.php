<?php

namespace App\Http\Controllers\Admin;

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

    public function index(Request $request)
    {
        $roles = $this->roleRepository->all();
        return view('admin.roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permissions = Permission::get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $id)
            ->pluck('permission_id', 'permission_id')
            ->all();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

  
}
