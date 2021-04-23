<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodIngredient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
