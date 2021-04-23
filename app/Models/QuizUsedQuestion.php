<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizUsedQuestion extends Model
{
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function quiz_question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}
