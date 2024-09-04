<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all()
    {
        return Project::all();
    }

    public function find($id)
    {
        return Project::find($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update($id, array $data)
    {
        $project = $this->find($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        $project = $this->find($id);
        $project->tasks()->delete();
    
        return $project->delete();
    }
}
