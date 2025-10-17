<?php

namespace Sdkconsultoria\OpenAiApi\Tests\Fake;

class ThreadFakeResponses
{
    public static function createdThread()
    {
        return [
            'id' => 'thread_iPddOOFKpb2lhXRDpj2P4wUH',
            'object' => 'thread',
            'created_at' => 1711673783,
            'metadata' => [],
        ];
    }

    public static function addedMessageThread()
    {
        return [
            'id' => 'msg_Owc3N0FCXO3khwA31rdnwY3N',
            'object' => 'thread.message',
            'created_at' => 1711675643,
            'assistant_id' => null,
            'thread_id' => 'thread_iPddOOFKpb2lhXRDpj2P4wUH',
            'run_id' => null,
            'role' => 'user',
            'content' => [
                [
                    'type' => 'text',
                    'text' => [
                        'value' => 'message',
                        'annotations' => [],
                    ],
                ],
            ],
            'file_ids' => [],
            'metadata' => [],
        ];
    }

    public static function createdAndRunThread()
    {
        return [
            'id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
            'object' => 'thread.run',
            'created_at' => 1711685581,
            'assistant_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
            'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
            'status' => 'queued',
            'started_at' => null,
            'expires_at' => 1711686181,
            'cancelled_at' => null,
            'failed_at' => null,
            'completed_at' => null,
            'required_action' => null,
            'last_error' => null,
            'model' => 'gpt-3.5-turbo-0125',
            'instructions' => 'You are a helpful assistant.',
            'tools' => [],
            'file_ids' => [],
            'metadata' => [],
            'usage' => null,
        ];
    }
}
