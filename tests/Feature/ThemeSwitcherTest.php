<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeSwitcherTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_todos_defaults_to_light_without_cookie(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/todos');

        $response->assertOk();
        $response->assertDontSee('class="dark"', false);
        $response->assertSee('aria-label="Theme"', false);
    }

    public function test_authenticated_todos_renders_dark_with_cookie(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withCookie('todolist_theme', 'dark')
            ->get('/todos');

        $response->assertOk();
        $response->assertSee('class="dark"', false);
    }

    public function test_profile_page_respects_dark_cookie(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withCookie('todolist_theme', 'dark')
            ->get('/profile');

        $response->assertOk();
        $response->assertSee('class="dark"', false);
    }

    public function test_invalid_theme_cookie_defaults_to_light(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withCookie('todolist_theme', 'purple')
            ->get('/todos');

        $response->assertOk();
        $response->assertDontSee('class="dark"', false);
    }

    public function test_theme_switcher_present_on_authenticated_todos(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/todos');

        $response->assertOk();
        $response->assertSee('aria-label="Theme"', false);
        $response->assertSee(__('Light'), false);
        $response->assertSee(__('Dark'), false);
    }

    public function test_theme_switcher_absent_on_login(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertDontSee('aria-label="Theme"', false);
        $response->assertDontSee('todolist_theme', false);
    }

    public function test_theme_switcher_absent_on_welcome(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('aria-label="Theme"', false);
    }
}
