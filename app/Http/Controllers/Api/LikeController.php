<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends ApiController
{
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $article = Article::findOrFail($id);
        $like = new Like();
        $like->article_id = $article->id;
        $like->user_id = $user->id;
        $like->save();

        $user->like();
        $article->like();



        if (is_null($like)) {
            return $this->sendError($like, 400);
        }

        return response($like, 201);
    }
}
