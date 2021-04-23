<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
}
