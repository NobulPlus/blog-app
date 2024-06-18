<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_comment_on_a_post()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user);

        $commentData = [
            'body' => 'This is a sample comment',
        ];

        $response = $this->post(route('comments.store', $post), $commentData);

        $response->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('comments', [
            'body' => 'This is a sample comment',
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function a_comment_requires_a_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', $post), [
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }
}
