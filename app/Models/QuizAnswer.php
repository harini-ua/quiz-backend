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

    public function quiz_question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function quiz_player()
    {
        return $this->belongsTo(QuizPlayer::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
