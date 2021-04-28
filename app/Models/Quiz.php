<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'players', 'code', 'answered_question', 'quiz_rounds'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizPlayers()
    {
        return $this->hasMany(QuizPlayer::class)
            ->orderBy('points','DESC');
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function quizAnswersByQuestion($id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id', $id);
    }

    public function quizAnswersByQuestionByVote($id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id', $id)
            ->where('answer', "");
    }

    public function quizHostAnswersByQuestion($id, $host_id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id', $id)
            ->where('quiz_player_id', $host_id);
    }
}
