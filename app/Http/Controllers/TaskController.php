<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(){
        $task = Task::all();
        return response($task);
    }

    public function store(TaskRequest $request, Task $task){
        return $task->create($request->all());
    }

    public function destroy(Task $task){
        $task->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
