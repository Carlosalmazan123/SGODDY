<?php

namespace Sdkconsultoria\OpenAiApi\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sdkconsultoria\OpenAiApi\Events\MessageReady;
use Sdkconsultoria\OpenAiApi\Lib\Assistant\ThreadManager;
use Sdkconsultoria\OpenAiApi\Models\Run;
use Sdkconsultoria\OpenAiApi\Models\Thread;

class PullingRunStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Run $run,
        public Thread $thread,
        public int $tried = 0,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = resolve(ThreadManager::class);
        $run = $service->getRunStatus($this->run);
        $this->run->status = $run['status'];
        $this->run->save();

        if ($run['status'] == 'completed') {
            $this->run->status = 'completed';
            $this->run->save();
            $response = $service->getMessages($this->thread);
            MessageReady::dispatch($this->run, $response);

            return;
        }
        $this->tried++;

        if ($this->tried < 3) {
            PullingRunStatus::dispatch($this->run, $this->thread, $this->tried)
                ->delay(now()->addSeconds(2));
        }
    }
}
