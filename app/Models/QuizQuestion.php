<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class QuizQuestion extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'description_spanish', 'description_german', 'category', 'image', 'audio'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::deleted(function($quizQuestion){
            $image = 'questions/'.$quizQuestion->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }

            $audio = 'questions/'.$quizQuestion->audio;
            if (Storage::exists($audio)) {
                Storage::delete($audio);
            }
        });
    }
}
