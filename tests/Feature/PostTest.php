<?php

namespace Tests\Feature;

use App\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    const POST_TABLE = 'blog_posts';

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_no_blog_posts_when_db_is_empty()
    {
        $reponse = $this->get('/posts');
        $reponse->assertStatus(200);
        $reponse->assertSeeText('There no posts found');
    }

    public function test_show_one_post_correctly()
    {
        // Arrage
        $post = $this->createPostSample();
        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
    }

    public function test_show_2_posts_correctly()
    {
        // Arrange
        $data = [
            [
                'title' => 'test is easy',
                'content' => 'as long as you do practice'
            ],
            [
                'title' => 'test in php',
                'content' => 'the principle is the same'
            ]
        ];
        BlogPost::insert($data);
        // Act
        $response = $this->get('/posts');
        // Assert
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['test is easy', 'test in php']);
        $this->assertDatabaseHas('blog_posts', ['title' => 'test is easy']);
        $this->assertDatabaseHas('blog_posts', ['title' => 'test in php']);
    }

    public function test_store_valid_post()
    {
        // Act
        $response = $this->followingRedirects()->post('/posts', [
            'title' => 'store a post',
            'content' => 'hope it works correctly'
        ]);
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Blog post has been created successfully');
        $response->assertSeeText('store a post');
        $this->assertDatabaseHas('blog_posts', ['title' => 'store a post']);
    }

    public function test_store_invalid_post()
    {
        // Act
        $response = $this->post('/posts', [
            'title' => '',
            'content' => ''
        ]);
        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title field is required.');
        $this->assertEquals($messages['content'][0], 'The content field is required.');
    }

    public function test_show_form_edit_post()
    {
        // Arrange
        $post = $this->createPostSample();
        $this->assertTrue($post->id > 0);
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->get(route('posts.edit', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSeeText($post->content);
    }

    public function test_update_valid_post()
    {
        // Arrange
        $post = $this->createPostSample();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->put(route('posts.update', ['post' => $post->id]), [
            'title' => 'data looks good',
            'content' => 'updating post worked'
        ]);
        // Assert
        $response->assertRedirect(route('posts.show', ['post' => $post->id]));
        $response->assertSessionHas('status', "Blog post #{$post->id} has been updated successfully");
        $this->assertDatabaseHas(self::POST_TABLE, ['title' => 'data looks good']);
        $this->assertDatabaseMissing(self::POST_TABLE, $post->toArray());
    }

    public function test_update_post_with_invalid_data()
    {
        // Arrange
        $post = $this->createPostSample();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->put(route('posts.update', ['post' => $post->id]), [
            'title' => 'xy',
            'content' => ''
        ]);
        $errors = session('errors')->getMessages();
        // Assert
        $response->assertStatus(302);
        $this->assertEquals($errors['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($errors['content'][0], 'The content field is required.');
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
    }

    public function test_destroy_valid_post()
    {
        // Arrange
        $post = $this->createPostSample();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->delete(route('posts.destroy', ['post' => $post->id]));
        // Assert
        $response->assertRedirect(route('posts.index'))->assertSessionHas('status', "Blog post #{$post->id} has been deleted successfully");
        $this->assertDatabaseMissing(self::POST_TABLE, $post->toArray());
    }

    private function createPostSample(): BlogPost
    {
        return BlogPost::create([
            'title' => 'a post sample',
            'content' => 'it is just dummy data'
        ]);
    }
}
