<?php

namespace App\Repositories;

use App\Events\NewTask;
use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::with('project')->get();
    }

    public function find($id): ?Task
    {
        return Task::with('project')->find($id);
    }

    public function create(array $data): Task
    {
        $task = Task::create($data);
        //with project
        $task->load('project');
        event(new NewTask($task));
        return $task;
    }

    public function update($id, array $data): bool
    {
        $task = $this->find($id);
        return $task ? $task->update($data) : false;
    }

    public function delete($id): bool
    {
        $task = $this->find($id);
        return $task ? $task->delete() : false;
    }

    public function findByProjectId($project_id): Collection
    {
        return Task::where('project_id', $project_id)->with('project')->get();
    }
}
