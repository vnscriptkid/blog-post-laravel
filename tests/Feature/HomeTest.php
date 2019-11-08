<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_returns_correct_content()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Welcome to Blog Post');
    }

    public function test_about_page_works_correctly()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSeeText('Learn more about');
    }

    public function test_about_page_for_non_admin()
    {
        $response = $this->actingAs($this->user())->get(route('about'));
        $response->assertStatus(200);
        $response->assertDontSeeText('Only admin can see this! Go next');
    }

    public function test_about_page_for_admin()
    {
        $response = $this->actingAs($this->admin())->get(route('about'));
        $response->assertStatus(200);
        $response->assertSeeText('Only admin can see this! Go next');
    }

    public function test_only_admin_can_see_secret_page()
    {
        $response = $this->actingAs($this->admin())->get(route('secret'));
        $response->assertStatus(200);
        $response->assertSeeText('This is the secret page for admin only');
    }

    public function test_non_admin_can_not_see_secret_page()
    {
        $response = $this->actingAs($this->user())->get(route('secret'));
        $response->assertStatus(403);
    }
}
