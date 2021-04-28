<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EventType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title' , 'description', 'image', 'title_spanish', 'title_german', 'description_spanish',
        'description_german'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::deleted(function($eventType){
            $image = 'event-types/'.$eventType->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
        });
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}
