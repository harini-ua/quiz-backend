<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
