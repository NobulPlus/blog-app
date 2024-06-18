<x-app-layout>

    @include('layouts.nav')

    <div class="container"> 

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <h2 class="title-text">All Posts</h2>
        @foreach ($posts as $post)
            <div class="post-item">
                <h3 class="title-content">{{ $post->title }}</h3>
                <p>{{ $post->excerpt }}</p>
                <p><strong>Category:</strong> {{ $post->category->title }}</p>
                <p><strong>Author:</strong> {{ $post->user->name }}</p>
                <a href="{{ route('posts.show', $post) }}">Read more</a>
            </div>
        @endforeach

        {{ $posts->links() }} <!-- Pagination links -->
    </div>
</x-app-layout>