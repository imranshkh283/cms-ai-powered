<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Chatting with OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $title = $this->ask('What is your question?');

        $chat = new \App\AI\Chat();

        $response = $chat->openRouteAi($title);

        $this->info($response);
    }
}
