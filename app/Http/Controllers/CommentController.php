<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        // Create a new comment for the post
        $comment = new Comment([
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
        ]);

        $post->comments()->save($comment);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        // Ensure that only the owner can delete the comment
        if ($comment->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
