<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Food extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'foods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'complexity_number', 'ingredients_number', 'minutes', 'image',
        'name_spanish', 'name_german', 'description_spanish', 'description_german'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::deleted(function($food){
            $image = 'foods/'.$food->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
        });
    }

    public function food_ingredients()
    {
        return $this->hasMany(FoodIngredient::class);
    }

    public function food_steps()
    {
        return $this->hasMany(FoodStep::class);
    }

    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }

    public function event_types()
    {
        return $this->belongsToMany(EventType::class);
    }
}
