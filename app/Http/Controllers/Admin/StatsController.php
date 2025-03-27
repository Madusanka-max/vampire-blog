<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'posts' => Post::where('status', 'published')->count(),
            'comments' => Comment::count(),
            'likes' => DB::table('likes')->count(),
        ];

        $postTrends = Post::selectRaw('DATE(published_at) as date, COUNT(*) as count')
                        ->where('published_at', '>', now()->subDays(30))
                        ->groupBy('date')
                        ->get();

        return view('admin.stats.index', compact('stats', 'postTrends'));
    }
}
