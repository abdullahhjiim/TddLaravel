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
        $this->list = TodoList::factory()->create();
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
        $name = TodoList::factory()->make()->name;

        $response = $this->postJson(route('todo-list.store'), ['name' => $name])
            ->assertCreated()
            ->json();

        $this->assertEquals($response['name'], $name);
        $this->assertDatabaseHas('todo_lists', ['name' => $name]);
    }

    public function test_validation_check_todo_list()
    {
        $this->withExceptionHandling();

        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
