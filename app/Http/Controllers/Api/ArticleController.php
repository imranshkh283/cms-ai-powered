<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ArticleRequest;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;


class ArticleController extends Controller
{
    use HttpResponse;

    protected ArticleService $articleService;


    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->index();
        return $this->success(ArticleResource::collection($articles), 'Articles retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ArticleRequest $request)
    {
        try {

            $data = $request->validated();
            $article = $this->articleService->create($data);

            return $this->created(new ArticleResource($article), 'Article created successfully');
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }

    public function update(UpdateArticleRequest $request, $id, ArticleService $articleService)
    {
        $data = $request->validated();

        $article = $articleService->findById($id);

        if (!$article) {
            return $this->notFound('Article not found');
        }

        $updatedArticle = $articleService->update($article, $data)->load('categories');

        return $this->success(new ArticleResource($updatedArticle), 'Article updated successfully');
    }

    public function delete(int $id)
    {
        $article = $this->articleService->findById($id);

        if (!$article) {
            return $this->notFound('Article not found');
        }

        try {
            $this->articleService->delete($article);

            return $this->success(null, 'Article deleted successfully');
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }
}
