<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasApiTokens, Notifiable, Searchable;
    
    protected $fillable = [
        'title',
        'slug',
        'content', 
        'image', 
        'category_id',
        'name',
        'email',
        'password',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => strip_tags($this->content),
            'category' => $this->category->name,
            'tags' => $this->tags->pluck('name')->join(' ')
        ];
    }
}
