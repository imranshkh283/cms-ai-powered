<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use App\Http\Traits\HttpResponse;
use App\Services\OpenRouterClient;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateArticleSlugSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HttpResponse;

    protected int $articleId;
    protected $data;
    public function __construct(int $articleId)
    {
        $this->articleId = $articleId;
        $this->data = null;
    }

    /**
     * Execute the job.
     */
    public function handle(OpenRouterClient $llm)
    {
        $article = Article::find($this->articleId);
        logger('Find Article data by id : ' . json_encode($article));
        if (!$article) {
            Log::error('article_id not found: ' . $this->articleId);
            return;
        }

        try {
            logger('Article Title: ' . $article->title . ', Content: ' . $article->content);
            $generated = $llm->generateSlugAndSummary($article->title, $article->content);
            $this->data = $generated;
            logger('Protected : ' . json_encode($this->data));
            logger('Object 1: ' . $generated);
            $article->update([
                'slug' => $this->data['slug'] ?? \Str::slug($article->title),
                'summary' => $this->data['summary'] ?? null,
            ]);
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }
}
