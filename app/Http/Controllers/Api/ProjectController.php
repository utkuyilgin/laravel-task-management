<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function fetchProjects()
    {
        $projects = $this->projectRepository->all();

        return response()->json(['data' => $projects]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->projectRepository->create($request->only(['name', 'description']));

        return response()->json(['message' => 'Project created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->projectRepository->update($id, $request->only(['name', 'description']));

        return response()->json(['message' => 'Project updated successfully']);
    }

    public function destroy($id)
    {
        $this->projectRepository->delete($id);

        return response()->json(['message' => 'Project deleted']);
    }
}
