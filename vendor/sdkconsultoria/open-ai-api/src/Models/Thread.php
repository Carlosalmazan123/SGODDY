<?php

namespace Sdkconsultoria\OpenAiApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    public function assistant()
    {
        return $this->belongsTo(Assistant::class);
    }
}
