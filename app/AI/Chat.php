<?php

namespace App\AI;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;

class Chat
{
    protected $messages = [];

    public function send(string $message)
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message,
        ];

        $response = Http::withOptions([
            'verify' => storage_path('certs/cacert.pem'),
        ])
            ->withToken(config('services.openai.secret'))
            ->post('https://openrouter.ai/api/v1', [
                'model' => 'gpt-3.5-turbo',
                'messages' => $this->messages,
            ]);

        if ($response->failed()) {
            logger('OpenAI error: ' . $response->body());
            throw new \Exception('OpenAI request failed: ' . $response->body());
        }

        logger('OpenAI response: ' . $response->body());

        $content = $response->json('choices.0.message.content');

        if ($content) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $content,
            ];
        }

        return $content;
    }

    public function prompt(string $prompt)
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $prompt,
        ];

        $response = OpenAI::chat()->create([
            "model" => "gpt-3.5-turbo",
            "messages" => $this->messages,
        ])->choices[0]->message->content;

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response,
            ];
        }

        return $response;
    }

    public function openRouteAi(string $title)
    {
        $content = $title;
        $this->messages[] = [
            'role' => 'user',
            'content' => "Generate a unique slug (max 60 characters, URL-safe) and a short summary (max 200 chars) for an article with title: \"$title\" and content: \"$content\". Respond strictly in JSON format like: {\"slug\": \"generated-slug\", \"summary\": \"generated-summary\"}",
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
            logger('OpenRouter error: ' . $response->body());
            throw new \Exception('OpenRouter request failed: ' . $response->body());
        }

        logger('OpenRouter response: ' . $response->body());

        $content = $response->json('choices.0.message.content');

        if ($content) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $content,
            ];
        }

        return $content;
    }
}
