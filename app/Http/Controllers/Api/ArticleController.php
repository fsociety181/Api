<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleController extends ApiController
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $articles = Article::all();

        if (is_null($articles)) {
            return $this->sendError($articles, 'Error received articles', 400);
        }

        return $this->sendResponse($articles, 'Articles successfully received', 200);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $article = Article::findOrFail($id);
//        getMedia('article_image')->first()->getUrl();

        if (is_null($article)) {
            return $this->sendError('Article not found', $article, 404);
        }
        $article->image = $article->getArticleImage();

        return $this->sendResponse($article, 'Article successfully received', 200);
    }

    public function create(ValidArticleRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $article = Article::create($data);

        if ($request->hasFile('img')) {
            $article->addMediaFromRequest('img')->toMediaCollection('article_image');
        }

        if (is_null($article)) {
            return $this->sendError('Valid error', $article, 400);
        }

        return $this->sendResponse($article, 'Article successfully create', 201);
    }

    public function update(ValidArticleRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $article = Article::firstWhere('id', $id)->update($request->all());

        if (is_null($article)) {
            return $this->sendError('Article not found', $article, 404);
        }

        return $this->sendResponse($article, 'Article successfully updates', 202);
    }

    public function destroy($id)
    {
        $delete = Article::where('id', $id)->find($id)->delete($id);

        if (is_null($delete)) {
            return $this->sendError('Article not found', $delete, 404);
        }

        return $this->sendResponse($delete, 'Article successfully deleted', 204);
    }
}
