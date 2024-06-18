<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_post()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user);

        $postData = [
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'excerpt' => 'This is a sample post for testing',
            'content' => 'This is the content of the sample post, note this is just for testing',
            'category_id' => $category->id,
            'published_at' => now(),
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'excerpt' => 'This is a sample post',
        ]);
    }
}
