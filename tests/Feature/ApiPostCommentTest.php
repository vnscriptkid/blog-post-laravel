<?php
// php artisan make:test ApiPostCommentTest
namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_with_no_comments()
    {
        // Arrange
        $newPost = factory(BlogPost::class)->create([
            'user_id' => $this->user()->id
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'id' => $newPost->id
        ]);
        // Act
        $response = $this->json('GET', "api/v1/posts/{$newPost->id}/comments");
        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function test_post_with_5_comments()
    {
        // Arrange
        $post = factory(BlogPost::class)->create([
            'user_id' => $this->user()->id
        ]);
        $this->assertEquals(BlogPost::count(), 1);
        $this->assertDatabaseHas('blog_posts', ['id' => $post->id]);

        // factory(Comment::class, 5)->make()->each(function ($comment) use ($post) {
        //     $comment->commentable_type = BlogPost::class;
        //     $comment->commentable_id = $post->id;
        //     $comment->user_id = $this->user()->id;
        //     $comment->save();
        // });
        $post->comments()->saveMany(
            factory(Comment::class, 5)->make([
                'user_id' => $this->user()->id
            ])
        );
        $this->assertEquals(Comment::count(), 5);

        $response = $this->json('GET', "api/v1/posts/{$post->id}/comments");
        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'content',
                        'created_at',
                        'updated_at',
                        'user' => [
                            'id',
                            'name',
                            'email'
                        ]
                    ]
                ]
            ]);
    }

    public function test_store_post_without_auth()
    {
        // Arrange
        $post = factory(BlogPost::class)->create([
            'user_id' => $this->user()->id
        ]);
        // Act
        $response = $this->json('POST', "api/v1/posts/{$post->id}/comments", [
            "content" => "unauth"
        ]);
        // Assert
        $response->assertStatus(401);
    }

    public function test_store_invalid_post()
    {
        // Arrange
        $post = factory(BlogPost::class)->create([
            'user_id' => $this->user()->id
        ]);
        // Act
        $response = $this->actingAs($this->user(), 'api')->json('POST', "api/v1/posts/{$post->id}/comments", []);
        // Assert
        $response->assertStatus(422)
            ->assertExactJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "content" => [
                        "The content field is required."
                    ]
                ]
            ]);
    }

    public function test_store_valid_post_success()
    {
        // Arrange
        $post = factory(BlogPost::class)->create([
            'user_id' => $this->user()->id
        ]);
        // Act
        $response = $this->actingAs($this->user(), 'api')->json('POST', "api/v1/posts/{$post->id}/comments", [
            "content" => "well done"
        ]);
        // Assert
        $response->assertStatus(201);
    }
}
