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
                $categoryId = $this->request->input('category_id');
                $q->whereHas('categories', function ($q2) use ($categoryId) {
                    $q2->where('categories.id', $categoryId);
                });
            })
            ->when($this->request->filled('status'), function ($q) {
                $status = $this->request->input('status');
                $q->where('status', $status);
            })
            ->when($this->request->filled('start_date') && $this->request->filled('end_date'), function ($q) {
                $startDate = $this->request->input('start_date');
                $endDate = $this->request->input('end_date');
                $q->whereBetween('published_at', [$startDate, $endDate]);
            });
    }
}
