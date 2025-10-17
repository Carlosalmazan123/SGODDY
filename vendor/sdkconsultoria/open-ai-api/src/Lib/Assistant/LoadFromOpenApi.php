<?php

namespace Sdkconsultoria\OpenAiApi\Lib\Assistant;

use Sdkconsultoria\OpenAiApi\Models\Assistant;
use Sdkconsultoria\OpenAiApi\Services\AssistantService;

class LoadFromOpenApi
{
    public function loadFromOpenAi()
    {
        $assistants = resolve(AssistantService::class)->loadFromOpenAi();

        foreach ($assistants['data'] as $assistant) {
            $model = new Assistant();
            $model->openai_id = $assistant['id'];
            $model->name = $assistant['name'];
            $model->model = $assistant['model'];
            $model->instructions = $assistant['instructions'];
            $model->save();
        }
    }
}
