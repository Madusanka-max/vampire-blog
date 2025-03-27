<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Post $post)
    {
        $user = $request->user();
        
        $user->likes()->toggle($post->id);

        return response()->json([
            'count' => $post->likes_count,
            'isLiked' => $user->likes()->where('post_id', $post->id)->exists()
        ]);
    }
}
