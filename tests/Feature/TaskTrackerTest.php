<?php

use App\Models\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('dashboard displays statistics and recent tasks', function () {
    Task::create([
        'title' => 'Important Task',
        'assigned_to' => 'Alex Smith',
        'priority' => 'High',
        'status' => 'Pending',
        'due_date' => now()->addDays(2)->toDateString(),
    ]);

    Task::create([
        'title' => 'Completed Task',
        'assigned_to' => 'Sarah Connor',
        'priority' => 'Low',
        'status' => 'Completed',
        'due_date' => now()->subDay()->toDateString(),
    ]);

    $response = $this->actingAs($this->user)->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Important Task')
        ->assertSee('50%'); // 1 of 2 completed
});

test('user can view task management list with search and filters', function () {
    Task::create([
        'title' => 'Develop API Endpoint',
        'assigned_to' => 'Rahim Ahmed',
        'priority' => 'High',
        'status' => 'Pending',
    ]);

    Task::create([
        'title' => 'Write Documentation',
        'assigned_to' => 'Karim Hasan',
        'priority' => 'Medium',
        'status' => 'In Progress',
    ]);

    $response = $this->actingAs($this->user)->get(route('tasks.index'));
    $response->assertOk()
        ->assertSee('Develop API Endpoint')
        ->assertSee('Write Documentation');

    // Search by title
    $searchResponse = $this->actingAs($this->user)->get(route('tasks.index', ['search' => 'API Endpoint']));
    $searchResponse->assertOk()
        ->assertSee('Develop API Endpoint')
        ->assertDontSee('Write Documentation');

    // Search by assigned person
    $assigneeResponse = $this->actingAs($this->user)->get(route('tasks.index', ['search' => 'Karim']));
    $assigneeResponse->assertOk()
        ->assertSee('Write Documentation')
        ->assertDontSee('Develop API Endpoint');

    // Filter by status
    $statusResponse = $this->actingAs($this->user)->get(route('tasks.index', ['status' => 'Pending']));
    $statusResponse->assertOk()
        ->assertSee('Develop API Endpoint')
        ->assertDontSee('Write Documentation');

    // Combined Search + Status + Priority
    Task::create([
        'title' => 'Urgent Deployment for Client',
        'assigned_to' => 'Rahim Ahmed',
        'priority' => 'High',
        'status' => 'In Progress',
    ]);

    $combinedResponse = $this->actingAs($this->user)->get(route('tasks.index', [
        'search' => 'Rahim',
        'status' => 'In Progress',
        'priority' => 'High',
    ]));

    $combinedResponse->assertOk()
        ->assertSee('Urgent Deployment for Client')
        ->assertDontSee('Develop API Endpoint') // Rahim but Pending
        ->assertDontSee('Write Documentation');
});

test('user can create a new task with validation', function () {
    $payload = [
        'title' => 'Launch Campaign',
        'description' => 'Coordinate social media push',
        'assigned_to' => 'Emma Watson',
        'priority' => 'High',
        'status' => 'Pending',
        'due_date' => now()->addDays(7)->toDateString(),
    ];

    $response = $this->actingAs($this->user)->post(route('tasks.store'), $payload);

    $response->assertRedirect(route('tasks.index'));
    $this->assertDatabaseHas('tasks', [
        'title' => 'Launch Campaign',
        'assigned_to' => 'Emma Watson',
    ]);
});

test('task creation fails when required fields are missing or invalid', function () {
    $response = $this->actingAs($this->user)->post(route('tasks.store'), [
        'title' => '',
        'assigned_to' => '',
        'priority' => 'InvalidPriority',
        'status' => 'InvalidStatus',
        'due_date' => 'invalid-date',
    ]);

    $response->assertSessionHasErrors(['title', 'assigned_to', 'priority', 'status', 'due_date']);
    expect(Task::where('title', '')->exists())->toBeFalse();
});

test('user can update an existing task', function () {
    $task = Task::create([
        'title' => 'Draft Wireframes',
        'assigned_to' => 'John Doe',
        'priority' => 'Medium',
        'status' => 'Pending',
    ]);

    $response = $this->actingAs($this->user)->put(route('tasks.update', $task), [
        'title' => 'Finalize Wireframes',
        'assigned_to' => 'John Doe',
        'priority' => 'High',
        'status' => 'Completed',
        'due_date' => now()->addDays(3)->toDateString(),
    ]);

    $response->assertRedirect(route('tasks.index'));
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Finalize Wireframes',
        'status' => 'Completed',
    ]);
});

test('user can delete a task', function () {
    $task = Task::create([
        'title' => 'Temporary Task',
        'assigned_to' => 'John Doe',
        'priority' => 'Low',
        'status' => 'Pending',
    ]);

    $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

    $response->assertRedirect(route('tasks.index'));
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

test('overdue accessor marks overdue pending tasks but not completed tasks', function () {
    $overdueTask = Task::create([
        'title' => 'Missed Deadline Task',
        'assigned_to' => 'John Doe',
        'priority' => 'High',
        'status' => 'Pending',
        'due_date' => now()->subDays(2)->toDateString(),
    ]);

    $completedPastTask = Task::create([
        'title' => 'Completed on time Task',
        'assigned_to' => 'John Doe',
        'priority' => 'High',
        'status' => 'Completed',
        'due_date' => now()->subDays(2)->toDateString(),
    ]);

    expect($overdueTask->is_overdue)->toBeTrue()
        ->and($completedPastTask->is_overdue)->toBeFalse();
});

test('tasks can be exported to CSV', function () {
    Task::create([
        'title' => 'Exportable Task',
        'assigned_to' => 'Export User',
        'priority' => 'Low',
        'status' => 'Pending',
    ]);

    $response = $this->actingAs($this->user)->get(route('tasks.export'));

    $response->assertOk()
        ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
});
