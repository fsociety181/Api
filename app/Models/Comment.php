<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->belongsToMany(Article::class, 'article_comment');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_comment');
    }
}
