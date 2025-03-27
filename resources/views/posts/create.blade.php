@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Create New Post</h1>
    
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Title</label>
            <input type="text" name="title" class="w-full rounded border-gray-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Category</label>
            <select name="category_id" class="w-full rounded border-gray-300" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Content</label>
            <input id="content" type="hidden" name="content">
            <trix-editor input="content" class="trix-content"></trix-editor>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Featured Image</label>
            <input type="file" name="image" class="block w-full text-sm text-gray-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded file:border-0
                  file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700
                  hover:file:bg-blue-100">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Publish Post</button>
    </form>
</div>
@endsection