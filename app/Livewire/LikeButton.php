<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeButton extends Component
{
    public Post $post;

    public function toggleLike()
    {
        Auth::user()->likes()->toggle($this->post);
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.like-button', [
            'isLiked' => Auth::user()->likes->contains($this->post),
            'count' => $this->post->likes_count
        ]);
    }
}
