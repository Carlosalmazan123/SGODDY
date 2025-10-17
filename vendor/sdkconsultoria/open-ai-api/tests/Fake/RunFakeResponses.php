<?php

namespace Sdkconsultoria\OpenAiApi\Tests\Fake;

class RunFakeResponses
{
    public static function addedRunToThread()
    {
        return self::getRun();
    }

    public static function getRun()
    {
        return [
            'id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
            'object' => 'thread.run',
            'created_at' => 1711688477,
            'assistant_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
            'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
            'status' => 'completed',
            'started_at' => 1711688477,
            'expires_at' => null,
            'cancelled_at' => null,
            'failed_at' => null,
            'completed_at' => 1711688479,
            'required_action' => null,
            'last_error' => null,
            'model' => 'gpt-3.5-turbo-0125',
            'instructions' => 'You are a helpful assistant.',
            'tools' => [],
            'file_ids' => [],
            'metadata' => [],
            'usage' => [
                'prompt_tokens' => 323,
                'completion_tokens' => 70,
                'total_tokens' => 393,
            ],
        ];
    }

    public static function getRuns()
    {
        return [
            'object' => 'list',
            'data' => [
                self::getRun(),
                [
                    'id' => 'run_2dZQFZiSSFqwXQlPw6fvOsCX',
                    'object' => 'thread.run',
                    'created_at' => 1711685581,
                    'assistant_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
                    'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
                    'status' => 'expired',
                    'started_at' => 1711685581,
                    'expires_at' => null,
                    'cancelled_at' => null,
                    'failed_at' => null,
                    'completed_at' => 1711685583,
                    'required_action' => null,
                    'last_error' => null,
                    'model' => 'gpt-3.5-turbo-0125',
                    'instructions' => 'Eres el amigable BOT asistente magico.',
                    'tools' => [],
                    'file_ids' => [],
                    'metadata' => [],
                    'usage' => [
                        'prompt_tokens' => 256,
                        'completion_tokens' => 54,
                        'total_tokens' => 310,
                    ],
                ],
            ],
            'first_id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
            'last_id' => 'run_2dZQFZiSSFqwXQlPw6fvOsCX',
            'has_more' => false,
        ];
    }

    public static function getMessages()
    {
        return [
            'object' => 'list',
            'data' => [
                [
                    'id' => 'msg_CGKZ9bjazvYkTyots04OnPS3',
                    'object' => 'thread.message',
                    'created_at' => 1711688477,
                    'assistant_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
                    'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
                    'run_id' => 'run_KpRc1KmHmj4pTtfwl1k0VAZp',
                    'role' => 'assistant',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'value' => 'Respuesta B',
                                'annotations' => [],
                            ],
                        ],
                    ],
                    'file_ids' => [],
                    'metadata' => [],
                ],
                [
                    'id' => 'msg_Ge1ShQrOIRoEgohLWrruOAnq',
                    'object' => 'thread.message',
                    'created_at' => 1711687394,
                    'assistant_id' => null,
                    'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
                    'run_id' => null,
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'value' => 'Donde estan ubicados?',
                                'annotations' => [],
                            ],
                        ],
                    ],
                    'file_ids' => [],
                    'metadata' => [],
                ],
                [
                    'id' => 'msg_a7iXg06TxBJhKSar11tjubf1',
                    'object' => 'thread.message',
                    'created_at' => 1711685582,
                    'assistant_id' => 'asst_NvIBVmO8Pt98JCsUWCDISWVz',
                    'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
                    'run_id' => 'run_2dZQFZiSSFqwXQlPw6fvOsCX',
                    'role' => 'assistant',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'value' => '¡Hola! Soy el amigable BOT asistente de la tienda los chavos. Nuestro horario de atención es de lunes a sábado de 9 am a 7 pm. ¿En qué más puedo ayudarte hoy?',
                                'annotations' => [],
                            ],
                        ],
                    ],
                    'file_ids' => [],
                    'metadata' => [],
                ],
                [
                    'id' => 'msg_ji8FmV7bmDxnhXOxjAnrvasE',
                    'object' => 'thread.message',
                    'created_at' => 1711685581,
                    'assistant_id' => null,
                    'thread_id' => 'thread_Hklgt9a1cgrSFhQpjcuKLwb6',
                    'run_id' => null,
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => [
                                'value' => 'hola ¿a que hora abren?',
                                'annotations' => [],
                            ],
                        ],
                    ],
                    'file_ids' => [],
                    'metadata' => [],
                ],
            ],
            'first_id' => 'msg_CGKZ9bjazvYkTyots04OnPS3',
            'last_id' => 'msg_ji8FmV7bmDxnhXOxjAnrvasE',
            'has_more' => false,
        ];
    }
}
