<!-- resources/views/components/search.blade.php -->
<form action="/search" method="GET">
    <input type="search" name="q" placeholder="Search posts..." 
           class="w-full px-4 py-2 rounded-lg border" 
           value="{{ request('q') }}">
</form>

<!-- Search Results -->
@foreach($posts as $post)
    <div class="search-result">
        <h3>{{ $post->title }}</h3>
        <p>{!! Str::markdown($post->searchable_content) !!}</p>
    </div>
@endforeach