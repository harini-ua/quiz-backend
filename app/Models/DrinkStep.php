<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DrinkStep extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'image', 'video', 'description_spanish', 'description_german'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::deleted(function($drinkStep){
            $image = 'drink-steps/'.$drinkStep->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }

            $video = 'drink-steps/'.$drinkStep->video;
            if (Storage::exists($video)) {
                Storage::delete($video);
            }
        });
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
}
