<?php

// database/factories/CommentFactory.php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
        ];
    }
}