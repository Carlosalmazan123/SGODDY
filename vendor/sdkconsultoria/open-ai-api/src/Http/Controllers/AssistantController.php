<?php

namespace Sdkconsultoria\OpenAiApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Sdkconsultoria\OpenAiApi\Lib\Assistant\LoadFromOpenApi;
use Sdkconsultoria\OpenAiApi\Models\Assistant;

class AssistantController extends Controller
{
    protected $resource = Assistant::class;

    public function loadFromOpenAi()
    {
        $service = resolve(LoadFromOpenApi::class);

        return $service->loadFromOpenAi();
    }
}
