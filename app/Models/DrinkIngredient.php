<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrinkIngredient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity'
    ];

    /**
     * Get the drink that owns the drink ingredient.
     */
    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
}
