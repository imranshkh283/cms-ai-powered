<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ArticleStatus;
use \App\Models\Category;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'status',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'status' => \App\Enums\ArticleStatus::class,
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted()
    {
        static::deleting(function ($article) {
            $article->categories()->detach();
        });
    }
}
