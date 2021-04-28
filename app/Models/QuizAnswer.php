<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer', 'points'
    ];

    public function quizQuestion()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function quizPlayer()
    {
        return $this->belongsTo(QuizPlayer::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
