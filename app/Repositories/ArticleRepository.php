<?php

namespace App\Repositories;

use App\Models\Article;
use App\Filters\Articles\ArticleFilterPipeline;

class ArticleRepository
{

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function attachCategories(Article $article, array $categoryIds): void
    {
        $article->categories()->sync($categoryIds);
    }

    public function update(Article $article, array $data): Article
    {
        $article->update($data);
        return $article;
    }

    public function findById(int $id): Article | null
    {
        return Article::find($id);
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }

    public function updateStatus(Article $article, array $data): Article
    {
        $article->update($data);
        return $article;
    }
}
