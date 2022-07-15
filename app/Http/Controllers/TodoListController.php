<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index() {
        $response = TodoList::all();
        return response($response);
    }

    public function show(TodoList  $todo_list) {
        return response($todo_list);
    }

    public function store(TodoListRequest $request){
        return TodoList::create($request->all());
    }

    public function update(TodoListRequest $request, TodoList $todo_list) {
        $todo_list->update($request->all());
        return $todo_list;
    }

    public function destroy(TodoList $todo_list) {
        $todo_list->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
