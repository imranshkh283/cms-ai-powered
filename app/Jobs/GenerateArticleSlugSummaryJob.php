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
            $this->data = json_decode($generated, true);
            logger('Object 1: ' . $generated);
            logger('Before update: ' . json_encode($this->data));

            $article->slug = $this->data['slug'];
            $article->summary = $this->data['summary'];
            $success = $article->save();

            logger('Save success status: ' . json_encode($success));
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }
}
