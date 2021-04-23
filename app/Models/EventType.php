<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}
