<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post_likes extends Model
{
    public $timestamps = false; // Kyunki table me sirf created_at hai

    protected $fillable = ['post_id', 'identifier_hash'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
