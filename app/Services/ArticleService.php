<?php

namespace App\Services;


use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

use App\Jobs\GenerateArticleSlugSummaryJob;

class ArticleService
{
    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function create(array $data)
    {
        $article = $this->articleRepository->create([
            'title'        => $data['title'],
            'content'      => $data['content'],
            'author_id'    => Auth::id(),
        ]);

        if (!empty($data['categories'])) {
            $this->articleRepository->attachCategories($article, $data['categories']);
        }

        // Dispatch LLM job
        GenerateArticleSlugSummaryJob::dispatch($article->id);

        return $article;
    }

    public function update(Article $article, array $data): Article
    {
        $this->articleRepository->update($article, [
            'title'        => $data['title'],
            'content'      => $data['content'],
            'status'       => 'Draft',
            'published_at' => null,
        ]);

        if (isset($data['category_ids'])) {
            $this->articleRepository->attachCategories($article, $data['category_ids']);
        }

        return $article;
    }

    public function findById(int $id): Article
    {
        return $this->articleRepository->findById($id);
    }

    public function delete(Article $article): void
    {
        $this->articleRepository->delete($article);
    }
}
