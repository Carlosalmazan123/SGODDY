<?php

namespace Sdkconsultoria\OpenAiApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\OpenAiApi\Models\Assistant;
use Sdkconsultoria\OpenAiApi\Models\Thread;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => $this->faker->word(),
            'openai_id' => $this->faker->word(),
            'assistant_id' => Assistant::factory(),
        ];
    }
}
