<?php

namespace Sdkconsultoria\OpenAiApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    use HasFactory;

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
