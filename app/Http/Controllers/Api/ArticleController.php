<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResouce;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleController extends ApiController
{

    public function index()
    {
        $articles = Article::all();

        if (is_null($articles)) {
            return $this->sendError($articles, 400);
        }

        return $this->sendResponse(ArticleResouce::collection($articles), 200);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        if (is_null($article)) {
            return $this->sendError($article, 404);
        }

        return response(new ArticleResouce($article), '200');
    }

    public function store(ValidArticleRequest $request)
    {
        $data = $request->validated();
        $article = Article::create($data);

        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')->toMediaCollection('article_image');
        }

        if (is_null($article)) {
            return $this->sendError($article, 400);
        }

        return $this->sendResponse($article, 201);
    }

    public function update(ValidArticleRequest $request, $id)
    {
        $data = $request->validated();

        $article = Article::findOrFail($id)
            ->update($data);

        if (is_null($article)) {
            return $this->sendError($article, 404);
        }

        return $this->sendResponse($article, 202);
    }

    public function destroy($id)
    {
        $delete = Article::where('id', $id)->find($id)->delete($id);

        if (is_null($delete)) {
            return $this->sendError($delete, 404);
        }

        return $this->sendResponse($delete, 204);
    }

    public function getArticle()
    {
        $articles = Article::all();

        if (is_null($articles)) {
            return $this->sendError($articles, 400);
        }

        return $this->sendResponse(ArticleResouce::collection($articles), 200);
    }
}
