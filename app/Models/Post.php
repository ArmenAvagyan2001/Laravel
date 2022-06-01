<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'image',
        'user_id'
    ];

    public function postUserLiked (): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_likes', 'post_id', 'user_id');
    }
}
