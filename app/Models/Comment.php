<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',
        'email',
        'comment_body',
        'status',
        'ip_address',
        'user_agent',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
