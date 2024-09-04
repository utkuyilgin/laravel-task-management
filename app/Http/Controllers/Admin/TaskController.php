<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;

        $this->middleware('permission:create task', ['only' => ['store']]);
        $this->middleware('permission:update task', ['only' => ['update']]);
        $this->middleware('permission:delete task', ['only' => ['destroy']]);
        $this->middleware('permission:view task', ['only' => ['index', 'show']]);
    }

    public function index($project_id)
    {
        $tasks = $this->taskRepository->findByProjectId($project_id);
        $project = Project::find($project_id);
        return view('admin.tasks.index', compact('project_id', 'tasks', 'project'));
    }

    public function create($project_id = null)
    {
        $projects = Project::all();
        $currentProject = Project::find($project_id);
        return view('admin.tasks.create', compact('projects', 'currentProject'));
    }

    public function edit($id)
    {
        $task = $this->taskRepository->find($id);
        $projects = Project::all();

        return view('admin.tasks.edit', compact('task', 'projects'));
    }   
}
