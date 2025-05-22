<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterClient
{
    protected array $messages = [];

    public function generateSlugAndSummary(string $title, string $content)
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => "Generate a JSON object with two fields: a unique, URL-safe slug (max 60 characters), and a short summary (max 200 characters) for the given article title and content. Respond with only the JSON object and no extra text or formatting. Example: {\"slug\": \"generated-slug\", \"summary\": \"generated-summary\"}",
        ];


        $response = Http::withOptions([
            'verify' => storage_path('certs/cacert.pem'),
        ])
            ->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'HTTP-Referer' => config('app.url'), // or hardcode e.g. 'https://yourdomain.com'
                'X-Title' => config('app.name'),     // or a custom string
                'Content-Type' => 'application/json',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-r1:free',
                'messages' => $this->messages,
            ]);

        if ($response->failed()) {
            Log::info('OpenRouter error: ' . $response->body());
            throw new \Exception('OpenRouter request failed: ' . $response->body());
        }
        Log::info('OpenRouter response: ' . json_encode($response->json()));
        $content = $response->json('choices.0.message.content');
        Log::info('OpenRouter raw content: ' . $content);
        return $content;
    }
}
