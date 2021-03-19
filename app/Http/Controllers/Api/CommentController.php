<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Auth;

class CommentController extends ApiController
{
    public function store(Request $request)
    {
        $article = Article::findOrFail($request->get('article_id'));
        $user = Auth::user();
        $comment = new Comment();
        $comment->text = $request->get('text');

        $comment->save();

        $article->comments()->attach($comment->id);
        $user->comment()->attach($comment->id);

        if (is_null($comment)) {
            return $this->sendError($comment, 400);
        }

        return response($comment, 201);
    }
}
