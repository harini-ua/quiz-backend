<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizPlayer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =  [
        'name', 'points', 'socket_id'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
