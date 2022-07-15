<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    private $list;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = $this->createTodoList();
    }

    public function test_todo_list_index()
    {
        $expect = 1;
        $response = $this->getJson(route('todo-list.index'));

        $this->assertEquals($expect, count($response->json()), 'Here is the message');
    }

    public function test_todo_single_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id))
                   ->assertOk()
                   ->json();

        $this->assertEquals($this->list->name, $response['name']);
    }

    public function test_todo_store_list()
    {
        $name = $this->makeTodoListColumn()->name;
        $title = $this->makeTodoListColumn()->title;

        $response = $this->postJson(route('todo-list.store'), ['name' => $name, 'title' => $title])
            ->assertCreated()
            ->json();

        $this->assertEquals($response['name'], $name);
        $this->assertDatabaseHas('todo_lists', ['name' => $name, 'title' => $title]);
    }

    public function test_validation_check_todo_list_while_insert()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'title']);
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);
    }

    public function test_todo_list_update()
    {
        $this->patchJson(route('todo-list.update', $this->list->id), ['name' => 'updated name', 'title' => 'update title'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['name' => 'updated name', 'title' => 'update title']);
    }

    public function test_validation_check_todo_list_while_udpate()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('todo-list.update', $this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'title']);
    }
}
