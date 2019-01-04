<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskCreated;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index(Admin $user)
    {
        return view('admin.task.index', compact('user'));
    }

    public function list(Admin $user)
    {
        //return Task::all()->pluck('body');
        return $user->tasks->pluck('body');
    }

    public function create(Request $request, Admin $user)
    {
        $task = $user->tasks()->create(['body' => $request->get('body')]);

        // 触发事件
        event(new TaskCreated($task));
        //\App\Events\OrderUpdated::dispatch();
    }
}
