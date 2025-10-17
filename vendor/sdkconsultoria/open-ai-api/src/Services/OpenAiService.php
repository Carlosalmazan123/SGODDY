<?php

namespace Sdkconsultoria\OpenAiApi\Services;

abstract class OpenAiService
{
    protected string $graph_url = 'https://api.openai.com/';

    protected string $endpoint = '';

    public function __construct()
    {
        $this->graph_url .= config('openai.api_version').'/'.$this->endpoint;
    }
}
