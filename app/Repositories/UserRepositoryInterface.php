<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function create(array $data);
    
}

