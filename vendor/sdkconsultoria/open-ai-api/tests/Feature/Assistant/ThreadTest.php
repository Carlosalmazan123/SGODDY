<?php

namespace Sdkconsultoria\OpenAiApi\Tests\Feature\Assistant;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\OpenAiApi\Events\MessageReady;
use Sdkconsultoria\OpenAiApi\Lib\Assistant\ThreadManager;
use Sdkconsultoria\OpenAiApi\Models\Assistant;
use Sdkconsultoria\OpenAiApi\Models\Thread;
use Sdkconsultoria\OpenAiApi\Tests\Fake\RunFakeResponses;
use Sdkconsultoria\OpenAiApi\Tests\Fake\ThreadFakeResponses;
use Sdkconsultoria\OpenAiApi\Tests\TestCase;

class ThreadTest extends TestCase
{
    use WithFaker;

    public function test_create_thread()
    {
        $assistant = Assistant::factory()->create();

        $clientIdentifier = $this->faker->word;
        Http::fake([
            '*/threads' => Http::response(ThreadFakeResponses::createdThread(), 200),
        ]);

        resolve(ThreadManager::class)->create($clientIdentifier, $assistant);

        $this->assertDatabaseHas('threads', [
            'identifier' => $clientIdentifier,
            'openai_id' => 'thread_iPddOOFKpb2lhXRDpj2P4wUH',
        ]);
    }

    public function test_add_message_to_thread()
    {
        $thread = Thread::factory()->create([
            'openai_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
        ]);
        $message = $this->faker->sentence;
        $message = 'Donde estan ubicados?';

        Http::fake([
            "*/threads/{$thread->openai_id}/messages" => Http::response(ThreadFakeResponses::addedMessageThread(), 200),
        ]);

        resolve(ThreadManager::class)->addMessage($thread, $message);
    }

    public function test_add_run_to_thread()
    {
        $assistant = Assistant::factory()->create([
            'openai_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
        ]);
        $thread = Thread::factory()->create([
            'openai_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
            'assistant_id' => $assistant->id,
        ]);

        Http::fake([
            "*/threads/{$thread->openai_id}/runs" => Http::response(RunFakeResponses::addedRunToThread(), 200),
            '*/threads/thread_Hklgt9a1cgrSFhQpjcuKLwb6/runs/run_KpRc1KmHmj4pTtfwl1k0VAZp' => Http::response(RunFakeResponses::getRun(), 200),
            '*/threads/thread_Hklgt9a1cgrSFhQpjcuKLwb6/messages' => Http::response(RunFakeResponses::getMessages(), 200),
        ]);

        resolve(ThreadManager::class)->addRunToThread($thread);

        $this->assertDatabaseHas('runs', [
            'openai_id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
        ]);
    }

    public function test_get_runs_from_thread()
    {
        $thread = Thread::factory()->create([
            'openai_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
        ]);

        Http::fake([
            "*/threads/{$thread->openai_id}/runs" => Http::response(RunFakeResponses::getRuns(), 200),
        ]);

        resolve(ThreadManager::class)->getRuns($thread);
    }

    public function test_delete_thread()
    {
        $thread = Thread::factory()->create([
            'openai_id' => 'thread_iPddOOFKpb2lhXRDpj2P4wUH',
        ]);

        Http::fake([
            "*/threads/{$thread->openai_id}" => Http::response([
                'id' => 'msg_Owc3N0FCXO3khwA31rdnwY3N',
                'object' => 'thread.deleted',
                'deleted' => true,
            ], 200),
        ]);

        resolve(ThreadManager::class)->delete($thread);

        $this->assertDatabaseMissing('threads', [
            'id' => $thread->id,
        ]);
    }

    public function test_create_thread_and_send_message_to_assistant()
    {
        $assistant = Assistant::factory()->create([
            'openai_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
        ]);
        $clientIdentifier = $this->faker->word;
        $message = $this->faker->sentence;
        $message = 'hola ¿a que hora abren?';

        Http::fake([
            '*/threads/runs' => Http::response(ThreadFakeResponses::createdAndRunThread(), 200),
            '*/threads/thread_Hklgt9a1cgrSFhQpjcuKLwb6/runs/run_KpRc1KmHmj4pTtfwl1k0VAZp' => Http::response(RunFakeResponses::getRun(), 200),
            '*/threads/thread_Hklgt9a1cgrSFhQpjcuKLwb6/messages' => Http::response(RunFakeResponses::getMessages(), 200),
        ]);
        Event::fake();
        resolve(ThreadManager::class)->createConversationWithAssistant($clientIdentifier, $message, $assistant);

        $this->assertDatabaseHas('threads', [
            'identifier' => $clientIdentifier,
            'openai_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
        ]);

        $this->assertDatabaseHas('runs', [
            'openai_id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
        ]);

        Event::assertDispatched(MessageReady::class);
    }
}
