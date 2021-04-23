<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'time', 'date', 'location', 'whatsapp_code'
    ];

    protected $dates = [
        'date_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event_type()
    {
        return $this->belongsTo(EventType::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
