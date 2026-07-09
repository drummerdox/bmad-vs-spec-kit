<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Livewire\Volt\Volt;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_todos(): void
    {
        $this->get('/todos')->assertRedirect('/login');
    }

    public function test_user_can_register_and_reach_todos_page(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect(route('todos', absolute: false));
        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component->assertRedirect(route('todos', absolute: false));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component->assertHasErrors();
        $this->assertGuest();
    }

    public function test_authenticated_user_can_add_todo(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\TodoList::class)
            ->set('title', 'Buy milk')
            ->set('priority', 'high')
            ->call('addTodo')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('todos', [
            'user_id' => $user->id,
            'title' => 'Buy milk',
            'priority' => 'high',
            'completed' => false,
        ]);
    }

    public function test_title_validation_rejects_short_titles(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(\App\Livewire\TodoList::class)
            ->set('title', 'ab')
            ->call('addTodo')
            ->assertHasErrors(['title']);
    }

    public function test_user_can_toggle_todo_completion(): void
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'user_id' => $user->id,
            'title' => 'Toggle me',
            'priority' => 'medium',
            'position' => 1,
            'completed' => false,
        ]);

        Livewire::actingAs($user)
            ->test(\App\Livewire\TodoList::class)
            ->call('toggle', $todo->id);

        $this->assertTrue($todo->fresh()->completed);
    }

    public function test_user_cannot_access_another_users_todo(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $todo = Todo::create([
            'user_id' => $owner->id,
            'title' => 'Private task',
            'priority' => 'low',
            'position' => 1,
        ]);

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($other)
            ->test(\App\Livewire\TodoList::class)
            ->call('toggle', $todo->id);
    }
}
