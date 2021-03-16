<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends ApiController
{

    public function index()
    {
        $articles = Article::all();

        if (is_null($articles)) {
            return $this->sendError($articles, 400);
        }

        return $this->sendResponse($articles, 200);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        if (is_null($article)) {
            return $this->sendError($article, 404);
        }

        return  response(new ArticleResource($article), '200');
    }

    public function create(ValidArticleRequest $request)
    {
        $data = $request->validated();
        $article = Article::create($data);

        if ($request->hasFile('img')) {
            $article->addMediaFromRequest('img')->toMediaCollection('article_image');
        }

        if (is_null($article)) {
            return $this->sendError($article, 400);
        }

        return $this->sendResponse($article, 201);
    }

    public function update(ValidArticleRequest $request, $id)
    {
        $article = Article::where('id', $id)->update($request->all());

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
}
