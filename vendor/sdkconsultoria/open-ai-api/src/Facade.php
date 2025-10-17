<?php

namespace Sdkconsultoria\OpenAiApi;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'OpenAiApi';
    }
}
