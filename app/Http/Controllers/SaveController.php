<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SaveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Post $post)
    {
        $user = $request->user();
        
        $user->saves()->toggle($post->id);

        return response()->json([
            'isSaved' => $user->saves()->where('post_id', $post->id)->exists()
        ]);
    }
}
