<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        return Post::search($request->query('q'))
            ->where('status', 'published')
            ->paginate(10);
    }
}
