<?php

namespace App\Http\Controllers\Admin;


use App\Models\Project;

class HomeController
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.home.index', compact('projects'));
    }
}