<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;


class Post extends Model
{
    use HasApiTokens, Notifiable;
    
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
}
