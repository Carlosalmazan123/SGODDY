<?php

namespace Sdkconsultoria\OpenAiApi\Services;

use Illuminate\Support\Facades\Http;

class ThreadService extends OpenAiService
{
    protected string $endpoint = 'threads';

    public function createConversationWithAssistant(string $message, string $assistantId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->post("$this->graph_url/runs", [
                'assistant_id' => $assistantId,
                'thread' => [
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $message,
                        ],
                    ],
                ],
            ])
            ->json();
    }

    public function getRunStatus(string $threadId, string $runId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->get("$this->graph_url/$threadId/runs/$runId")
            ->json();
    }

    public function getMessages(string $threadId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->get("$this->graph_url/$threadId/messages")
            ->json();
    }

    public function create()
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->post($this->graph_url)
            ->json();
    }

    public function addMessage(string $threadId, string $message)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->post("$this->graph_url/$threadId/messages", [
                'role' => 'user',
                'content' => $message,
            ])
            ->json();
    }

    public function addRunToThread(string $threadId, string $assistantId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->post("$this->graph_url/$threadId/runs", [
                'assistant_id' => $assistantId,
            ])
            ->json();
    }

    public function getRuns(string $threadId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->get("$this->graph_url/$threadId/runs")
            ->json();
    }

    public function delete(string $threadId)
    {
        return Http::withToken(config('openai.token'))
            ->withToken(config('openai.token'))
            ->withHeader('OpenAI-Beta', 'assistants=v1')
            ->throw()
            ->delete("$this->graph_url/$threadId")
            ->json();
    }
}
