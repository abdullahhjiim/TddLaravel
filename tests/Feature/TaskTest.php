<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    private $task;

    public function test_all_task_index()
    {
        $this->task = $this->createTask();

        $response = $this->getJson(route('tasks.index'))->assertOk()->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($this->task->title, $response[0]['title']);
    }

    public function test_store_task_for_todo()
    {
        $task = $this->makeTaskColumn();

        $this->postJson(route('tasks.store'), ['title' => $task->title])
            ->assertCreated();

        $this->assertDatabaseHas('tasks', ['title' => $task->title]);
    }

    public function test_delete_task_check()
    {
        $this->task = $this->createTask();

        $this->deleteJson(route('tasks.destroy', $this->task->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['title' => $this->task->title]);
    }
}
