<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'content'       => $this->content,
            'summary'       => $this->summary,
            'status'        => $this->status,
            'published_at'  => $this->published_at,
            'author_id'     => $this->author_id,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'category'      => $this->categories->pluck('name')->toArray(),
        ];
    }
}
