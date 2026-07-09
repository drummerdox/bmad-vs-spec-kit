<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_homepage_has_open_graph_and_json_ld(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('property="og:title"', false);
        $response->assertSee('property="og:description"', false);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('WebApplication', false);
        $response->assertSee('Organize your day with Todo App', false);
    }

    public function test_robots_txt_is_accessible(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('User-agent: *');
        $response->assertSee('Sitemap:');
    }

    public function test_sitemap_xml_is_accessible(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<loc>'.config('app.url').'/</loc>', false);
        $response->assertSee('<loc>'.config('app.url').'/login</loc>', false);
        $response->assertSee('<loc>'.config('app.url').'/register</loc>', false);
    }

    public function test_login_page_has_unique_title(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('<title>Log in — Todo App</title>', false);
    }

    public function test_register_page_has_unique_title(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('<title>Create account — Todo App</title>', false);
    }
}
