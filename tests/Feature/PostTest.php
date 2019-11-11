<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use App\User;
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
        $post = $this->createPost();
        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($post->title);
        $response->assertSeeText('No comment yet');
    }

    public function test_show_one_post_with_3_comments()
    {
        // Arrange
        $post = $this->createPost();
        factory(Comment::class, 3)->make()->each(function ($comment) use ($post) {
            $comment->commentable_id = $post->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $this->user()->id;
            $comment->save();
        });

        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('3 comments');
    }

    public function test_show_2_posts_correctly()
    {
        // Arrange
        $firstPost = $this->createPost();
        $secondPost = $this->createPost();
        // Act
        $response = $this->get('/posts');
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($firstPost->title);
        $response->assertSeeText($secondPost->title);
        // $this->assertDatabaseHas(self::POST_TABLE, $posts[0]->toArray());
        // $this->assertDatabaseHas(self::POST_TABLE, $posts[1]->toArray());
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

    public function test_show_form_edit_post_for_author()
    {
        // Arrange
        $post = $this->createPost();
        // Act
        $response = $this->actingAs($post->user)->get(route('posts.edit', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSeeText($post->content);
    }

    public function test_not_showing_edit_post_form_for_unauthorized_user()
    {
        // Arrange
        $post = $this->createPost();
        // Act
        $response = $this->actingAs($this->user())->get(route('posts.edit', ['post' => $post->id]));
        // Assert
        $response->assertStatus(403);
    }

    public function test_update_valid_post()
    {
        // Arrange
        $post = $this->createPost();
        $data = [
            'title' => 'data looks good',
            'content' => 'updating post worked'
        ];
        // Act
        $response = $this->actingAs($post->user)->put(route('posts.update', ['post' => $post->id]), $data);
        // Assert
        $response->assertRedirect(route('posts.show', ['post' => $post->id]));
        $response->assertSessionHas('status', "Blog post #{$post->id} has been updated successfully");
        $this->assertDatabaseHas(self::POST_TABLE, ['title' => $data['title']]);
        $this->assertDatabaseMissing(self::POST_TABLE, ['title' => $post->title]);
    }

    public function test_update_post_with_invalid_data()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createPost();
        // Act
        $response = $this->actingAs($user)->put(route('posts.update', ['post' => $post->id]), [
            'title' => 'xy',
            'content' => ''
        ]);
        $errors = session('errors')->getMessages();
        // Assert
        $response->assertStatus(302);
        $this->assertEquals($errors['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($errors['content'][0], 'The content field is required.');
    }

    public function test_destroy_valid_post()
    {
        // Arrange
        $post = $this->createPost();
        $this->assertDatabaseHas(self::POST_TABLE, ['id' => $post->id]);
        // Act
        $response = $this->actingAs($post->user)->delete(route('posts.destroy', ['post' => $post->id]));
        // Assert
        $response->assertRedirect(route('posts.index'))->assertSessionHas('status', "Blog post #{$post->id} has been deleted successfully");
        $this->assertSoftDeleted(self::POST_TABLE, ['id' => $post->id]);
    }

    public function test_destroy_post_by_authorized_user_returns_403()
    {
        // Arrange
        $post = $this->createPost();
        $this->assertDatabaseHas(self::POST_TABLE, ['id' => $post->id]);
        // Act
        $response = $this->actingAs($this->user())->delete(route('posts.destroy', ['post' => $post->id]));
        // Assert
        $response->assertStatus(403);
    }

    public function test_show_post_detail_with_no_comment()
    {
        // Arrange
        $post = $this->createPost();
        $this->assertDatabaseHas(self::POST_TABLE, ['id' => $post->id]);
        // Act
        $response = $this->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText("There's no comment yet");
    }

    public function test_show_post_detail_with_multiple_comments()
    {
        // Arrange
        $post = $this->createPost();
        $comments = factory(Comment::class, 2)->make()->each(function ($comment) use ($post) {
            $comment->commentable_id = $post->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $this->user()->id;
            $comment->save();
        });
        // Act
        $response = $this->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSee($comments[0]->content);
        $response->assertSee($comments[1]->content);
    }

    public function test_author_of_post_showed_in_index_page()
    {
        // Arrange
        $user = $this->user();
        $post = $this->createPost($user);
        $this->assertDatabaseHas(self::POST_TABLE, ['id' => $post->id]);
        // Act
        $response = $this->get(route('posts.index'));
        // Assert
        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_detail_page_for_author_should_include_edit_and_delete_buttons()
    {
        // Arrange
        $post = $this->createPost();
        // Act
        $response = $this->actingAs($post->user)->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Edit');
        $response->assertSeeText('Delete');
    }

    public function test_detail_page_for_normal_user_should_not_include_edit_and_delete_buttons()
    {
        // Arrange
        $post = $this->createPost();
        // Act
        $response = $this->actingAs($this->user())->get(route('posts.show', ['post' => $post->id]));
        // Assert
        $response->assertStatus(200);
        $response->assertDontSeeText('Edit');
        $response->assertDontSeeText('Delete');
    }
}
