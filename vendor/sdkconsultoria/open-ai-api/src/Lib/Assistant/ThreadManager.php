<?php

namespace Sdkconsultoria\OpenAiApi\Lib\Assistant;

use Sdkconsultoria\OpenAiApi\Jobs\PullingRunStatus;
use Sdkconsultoria\OpenAiApi\Models\Assistant;
use Sdkconsultoria\OpenAiApi\Models\Run;
use Sdkconsultoria\OpenAiApi\Models\Thread;
use Sdkconsultoria\OpenAiApi\Services\ThreadService;

class ThreadManager
{
    public function createConversationWithAssistant(string $identifier, string $message, Assistant $assistant)
    {
        $response = resolve(ThreadService::class)->createConversationWithAssistant($message, $assistant->openai_id);
        $thread = $this->saveThread($identifier, $response['thread_id'], $assistant);
        $run = $this->saveRun($thread, $response);

        PullingRunStatus::dispatch($run, $thread)->delay(now()->addSeconds(3));

        return $response;
    }

    private function saveThread(string $identifier, string $openai_id, Assistant $assistant)
    {
        $thread = new Thread();
        $thread->identifier = $identifier;
        $thread->openai_id = $openai_id;
        $thread->assistant_id = $assistant->id;
        $thread->save();

        return $thread;
    }

    private function saveRun(Thread $thread, array $response)
    {
        $run = new Run();
        $run->thread_id = $thread->id;
        $run->openai_id = $response['id'];
        $run->status = 'queued';
        $run->expires_at = $response['expires_at'];
        $run->save();

        return $run;
    }

    public function getRunStatus(Run $run)
    {
        return resolve(ThreadService::class)->getRunStatus($run->thread->openai_id, $run->openai_id);
    }

    public function getMessages(Thread $thread)
    {
        return resolve(ThreadService::class)->getMessages($thread->openai_id);
    }

    public function create(string $identifier, Assistant $assistant): Thread
    {
        $response = resolve(ThreadService::class)->create($identifier);

        return $this->saveThread($identifier, $response['id'], $assistant);
    }

    public function addMessage(Thread $thread, string $message)
    {
        return resolve(ThreadService::class)->addMessage($thread->openai_id, $message);
    }

    public function addRunToThread(Thread $thread)
    {
        $response = resolve(ThreadService::class)->addRunToThread($thread->openai_id, $thread->assistant->openai_id);
        $run = $this->saveRun($thread, $response);
        PullingRunStatus::dispatch($run, $thread)->delay(now()->addSeconds(5));
    }

    public function getRuns(Thread $thread)
    {
        return resolve(ThreadService::class)->getRuns($thread->openai_id);
    }

    public function delete(Thread $thread)
    {
        $response = resolve(ThreadService::class)->delete($thread->openai_id);
        $thread->delete();

        return $response;
    }
}
