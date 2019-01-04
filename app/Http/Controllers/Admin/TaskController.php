<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskCreated;
use App\Models\Admin\Admin;
use App\Models\Admin\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        return view('admin.task.index', compact('project'));
    }

    public function list(Project $project)
    {
        //return Task::all()->pluck('body');
        return $project->tasks->pluck('body');
    }

    public function create(Request $request, Project $project)
    {
        $task = $project->tasks()->create(['body' => $request->get('body')]);

        // 触发事件
        event(new TaskCreated($task));
        //\App\Events\OrderUpdated::dispatch();
    }
}
