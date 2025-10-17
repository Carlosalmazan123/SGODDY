<?php

namespace Sdkconsultoria\OpenAiApi;

use Illuminate\Support\Facades\Route;

class OpenAiApi
{
    public static function routes()
    {
        return function () {
            Route::get('assistant/load-from-openai', 'AssistantController@loadFromOpenAi')->name('assistant.from_openai');
        };
    }
}
