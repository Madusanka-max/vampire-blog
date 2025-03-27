<!-- Likes -->
<button class="like-btn" data-post="{{ $post->id }}">
    ❤️ <span class="count">{{ $post->likes_count }}</span>
</button>

<!-- Save -->
<button class="save-btn" data-post="{{ $post->id }}">
    {{ auth()->user()->saves->contains($post) ? '★' : '☆' }}
</button>

<!-- Comments -->
@foreach($post->comments as $comment)
    <div class="comment">
        <p>{{ $comment->content }}</p>
        @can('delete', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endcan
    </div>
@endforeach

<form action="{{ route('comments.store', $post) }}" method="POST">
    @csrf
    <textarea name="content" placeholder="Add comment..."></textarea>
    <button>Post Comment</button>
</form>