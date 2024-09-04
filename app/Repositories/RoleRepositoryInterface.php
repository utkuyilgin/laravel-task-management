<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?Role;

    public function create(array $data): Role;

    public function update($id, array $data): ?Role;

    public function delete($id): void;
}
