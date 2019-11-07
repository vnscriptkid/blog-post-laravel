<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    const POST_TABLE = 'blog_posts';
    const COMMENT_TABLE = 'comments';

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

    public function test_show_one_post_no_comment_correctly()
    {
        // Arrage
        $post = factory(BlogPost::class)->create();
        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText('No comment yet');
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
    }

    public function test_show_one_post_with_3_comments()
    {
        // Arrange
        $post = factory(BlogPost::class)->create();
        factory(Comment::class, 3)->create(['blog_post_id' => $post->id]);

        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('3 comments');
    }

    public function test_show_2_posts_correctly()
    {
        // Arrange
        $posts = factory(BlogPost::class, 2)->create();
        // Act
        $response = $this->get('/posts');
        // Assert
        $response->assertStatus(200);
        $response->assertSeeTextInOrder([$posts[0]->title, $posts[1]->title]);
        $this->assertDatabaseHas(self::POST_TABLE, $posts[0]->toArray());
        $this->assertDatabaseHas(self::POST_TABLE, $posts[1]->toArray());
    }

    public function test_store_valid_post()
    {
        // Act
        $response = $this->actingAs($this->user())->followingRedirects()->post('/posts', [
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
        $response = $this->actingAs($this->user())->post('/posts', [
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
        $post = factory(BlogPost::class)->create();
        $this->assertTrue($post->id > 0);
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->actingAs($this->user())->get(route('posts.edit', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSeeText($post->content);
    }

    public function test_update_valid_post()
    {
        // Arrange
        $post = factory(BlogPost::class)->create();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->actingAs($this->user())->put(route('posts.update', ['post' => $post->id]), [
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
        $post = factory(BlogPost::class)->create();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->actingAs($this->user())->put(route('posts.update', ['post' => $post->id]), [
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
        $post = factory(BlogPost::class)->create();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->actingAs($this->user())->delete(route('posts.destroy', ['post' => $post->id]));
        // Assert
        $response->assertRedirect(route('posts.index'))->assertSessionHas('status', "Blog post #{$post->id} has been deleted successfully");
        $this->assertDatabaseMissing(self::POST_TABLE, $post->toArray());
    }

    public function test_show_post_detail_with_no_comment()
    {
        // Arrange
        $post = factory(BlogPost::class)->create();
        $this->assertDatabaseHas(self::POST_TABLE, $post->toArray());
        // Act
        $response = $this->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText("There's no comment yet");
    }

    public function test_show_post_detail_with_multiple_comments()
    {
        // Arrange
        $post = factory(BlogPost::class)->create();
        $comments = factory(Comment::class, 2)->create(['blog_post_id' => $post->id]);

        // Act
        $response = $this->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeInOrder([$comments[0]->content, $comments[1]->content]);
    }
}
