<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    // Define the comments relationship
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Define the category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
