<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'status' => 'required',
        ]);

        $this->taskRepository->create($request->all());

        return response()->json(['message' => 'Task created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'status' => 'required',
        ]);

        $this->taskRepository->update($id, $request->all());

        return response()->json(['message' => 'Task updated successfully']);
    }

    public function destroy($id)
    {
        $task = $this->taskRepository->find($id);
        $project_id = $task->project_id;
        $this->taskRepository->delete($id);

        return response()->json(['message' => 'Task deleted']);
    }

    public function fetchTasks()
    {
        $tasks = $this->taskRepository->all();

        return response()->json(['data' => $tasks]);
    }

    public function fetchTasksByProject($project_id)
    {
        $tasks = $this->taskRepository->findByProjectId($project_id);

        return response()->json(['data' => $tasks]);
    }
}
