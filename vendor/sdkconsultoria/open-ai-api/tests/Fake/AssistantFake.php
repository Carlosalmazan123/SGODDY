<?php

namespace Sdkconsultoria\OpenAiApi\Tests\Fake;

class AssistantFake
{
    public static function loadFromOpenAi()
    {
        return [
            'object' => 'list',
            'data' => [
                [
                    'id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
                    'object' => 'assistant',
                    'created_at' => 1709268701,
                    'name' => 'BOT Los Chavos',
                    'description' => null,
                    'model' => 'gpt-3.5-turbo-0125',
                    'instructions' => 'Eres el amigable BOT asistente magico.',
                    'tools' => [],
                    'file_ids' => [],
                    'metadata' => [],
                ],
            ],
            'first_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
            'last_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
            'has_more' => false,
        ];
    }
}
