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

    public function quiz_players()
    {
        return $this->hasMany(QuizPlayer::class)
            ->orderBy('points','DESC');
    }

    public function quiz_answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function quiz_answers_for_question($id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id','=',$id);
    }

    public function quiz_answers_for_question_for_vote($id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id','=',$id)
            ->where('answer','!=',"");
    }

    public function quiz_host_answers_for_question($id, $host_id)
    {
        return $this->hasMany(QuizAnswer::class)
            ->where('quiz_question_id','=',$id)
            ->where('quiz_player_id','=',$host_id);
    }
}
