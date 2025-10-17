<?php

namespace Sdkconsultoria\OpenAiApi\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Sdkconsultoria\OpenAiApi\Models\Run;

class MessageReady
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Run $run,
        public array $messages,
    ) {
    }
}
