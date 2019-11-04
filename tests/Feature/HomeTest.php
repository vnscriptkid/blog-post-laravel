<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_returns_correct_content()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Welcome to our blog post');
    }

    public function test_about_page_works_correctly()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSeeText('Learn more about');
    }
}
