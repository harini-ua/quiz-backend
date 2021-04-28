<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FoodStep extends Model
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

        self::deleted(function($foodStep){
            $image = 'food-steps/'.$foodStep->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }

            $video = 'food-steps/'.$foodStep->video;
            if (Storage::exists($video)) {
                Storage::delete($video);
            }
        });
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
