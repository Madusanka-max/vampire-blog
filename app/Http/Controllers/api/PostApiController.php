<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostApiController extends Controller
{
    public function index()
    {
        return Post::with(['user', 'category'])
            ->published()
            ->paginate(10);
    }

    public function show(Post $post)
    {
        return $post->load(['comments.user', 'tags']);
    }
}
