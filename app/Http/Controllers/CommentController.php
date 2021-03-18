<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class CommentController extends ApiController
{
    public function index()
    {
        $comments = Comment::all();

        if (is_null($comments)) {
            return $this->sendError($comments, 404);
        }

        return $this->sendResponse($comments, 200);
    }

    public function show($id)
    {
        $comment = Comment::firstOrFail($id);

        if (is_null($comment)) {
            return $this->sendError($comment, 404);
        }

        return $this->sendResponse($comment, 200);
    }

    public function store(Request $request)
    {
        $article = Article::findOrFail($request->get('article_id'));
        $user = User::findOrFail($request->get('user_id'));
        $comment = new Comment();
        $comment->text = $request->get('text');
        $comment->save();
        $article->comments()->attach($comment->id);
        $user->comment()->attach($comment->id);

        return response($comment,200);
    }
}
