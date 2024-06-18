<x-app-layout>
<div class="container">
    <div class="post">
        <h1 class="title-page">{{ $post->title }}</h1>
        <div class="post-head">
            <p><strong>Category:</strong> {{ $post->category->title }}</p>
            <p><strong>Author:</strong> {{ $post->user->name }}</p>
            <p><strong>Published:</strong> {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</p>
        </div>
        <div class="content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </div>

    @auth
        <div class="mt-5">
            <h2>Add a Comment</h2>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3" required>{{ old('body') }}</textarea>
                </div>
                <div class="submit_button">
                    <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
                    <button class="back"><a href="{{ route('posts.index') }}">Back to all posts</a></button>
                </div>
            </form>
        </div>
    @endauth

    <div class="mt-5">
        <h2 class="title-comment">Comments</h2>
        @foreach ($post->comments as $comment)
            <div class="comment">
                <p>{{ $comment->body }}</p>
                <p><small>{{ $comment->user->name }} - {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y H:i') }}</small></p>
                @can('delete', $comment)
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endcan
            </div>
        @endforeach
    </div>
</div>
</x-app-layout>