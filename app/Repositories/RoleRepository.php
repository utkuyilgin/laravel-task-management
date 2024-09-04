<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    public function all(): Collection
    {
        return Role::all();
    }

    public function find($id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        return Role::create(['name' => $data['name']]);
    }

    public function update($id, array $data): ?Role
    {
        $role = Role::find($id);
        if ($role) {
            $role->name = $data['name'];
            $role->save();
        }
        return $role;
    }

    public function delete($id): void
    {
        Role::destroy($id);
    }
}
