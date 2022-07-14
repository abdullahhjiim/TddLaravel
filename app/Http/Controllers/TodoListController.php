<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index() {
        $response = TodoList::all();
        return response($response);
    }
    public function show(TodoList  $todo) {
        return response($todo);
    }
    public function store(Request  $request){
        $this->validate(['name' => 'required'], $request);
        return TodoList::create($request->all());
    }
}
