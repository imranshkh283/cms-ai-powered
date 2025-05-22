<?php

namespace App\Filters\Articles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleFilter
{
    protected Builder $query;
    protected Request $request;

    public function __construct(Builder $query, Request $request)
    {
        $this->query = $query;
        $this->request = $request;
    }

    public function apply()
    {
        return $this->query
            ->when($this->request->filled('category_id'), function ($q) {
                $q->whereHas('categories', function ($q2) {
                    // $q2->whereIn('categories.id', $this->request->category_id); // TODO: fix this
                    $q2->where('categories.id', $this->request->category_id);
                });
            })
            ->when($this->request->filled('status'), function ($q) {
                $q->where('status', $this->request->status);
            })
            ->when($this->request->filled('start_date') && $this->request->filled('end_date'), function ($q) {
                $q->whereBetween('published_at', [
                    $this->request->start_date,
                    $this->request->end_date
                ]);
            });
    }
}
