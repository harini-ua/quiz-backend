<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Drink extends Model
{
    use SoftDeletes;

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

        self::deleted(function($drink){
            $image = 'drinks/'.$drink->image;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
        });
    }

    public function drink_ingredients()
    {
        return $this->hasMany(DrinkIngredient::class);
    }

    public function drink_steps()
    {
        return $this->hasMany(DrinkStep::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}
