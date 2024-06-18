<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
// use App\Http\Controllers\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'user')->latest()->paginate(10); // Get latest 10 published posts with relationships
        return view('posts.index', compact('posts')); // Pass posts to the view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get categories for the dropdown in the form
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:posts|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        // Generate slug from title
        $slug = Str::slug($request->input('title'), '-');

        // Generate excerpt from content (first 100 characters, adjust as needed)
        $excerpt = Str::limit(strip_tags($request->input('content')), 100);

        // Add user_id and published_at to validated data
        $validatedData['slug'] = $slug;
        $validatedData['excerpt'] = $excerpt;
        $validatedData['user_id'] = auth()->id();
        $validatedData['published_at'] = now(); // Current timestamp

        // Create the post
        $post = Post::create($validatedData);

        // Redirect to a specific route (e.g., the post index or the created post's show page)
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with(['comments.user', 'category', 'user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post->load('category'); // Eager load category for the edit form
        $categories = Category::all(); // Get all categories for the dropdown
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $post->id, // Exclude current post ID for slug uniqueness
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'published_at' => nullable, // Optional published date
        ]);

        $post->update($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
