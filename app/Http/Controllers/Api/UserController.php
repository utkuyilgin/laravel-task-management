<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchUsers()
    {
        $users = $this->userRepository->all();
        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_ids' => 'nullable|array',
        ]);

        $user = $this->userRepository->create($request->all());
        $user->roles()->sync($request->role_ids);

        return response()->json(['message' => 'User created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_ids' => 'nullable|array',
        ]);

        $user = $this->userRepository->update($id, $request->all());
        $user->roles()->sync($request->role_ids);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return response()->json(['message' => 'User deleted']);
    }
}
