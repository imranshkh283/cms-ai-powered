<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{

    public function getAllArticle()
    {
        return Article::all();
    }

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

    public function findById(int $id): Article
    {
        return Article::find($id);
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
