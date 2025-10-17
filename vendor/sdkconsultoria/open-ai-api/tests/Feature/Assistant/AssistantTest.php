<?php

namespace Sdkconsultoria\OpenAiApi\Tests\Feature\Assistant;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\OpenAiApi\Tests\Fake\AssistantFake;
use Sdkconsultoria\OpenAiApi\Tests\TestCase;

class AssistantTest extends TestCase
{
    public function test_load_from_openai()
    {
        Http::fake([
            '*/assistants' => Http::response(AssistantFake::loadFromOpenAi(), 200),
        ]);
        $response = $this->get(route('assistant.from_openai'));
        $response->assertStatus(200);

        $this->assertDatabaseCount('assistants', 1);
    }
}
