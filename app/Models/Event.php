<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'event_date', 'description', 'content_table'];

    protected $casts = [
        'content_table' => 'array',
        'event_date' => 'date'
    ];

    public function images()
    {
        return $this->hasMany(EventImage::class)->orderBy('sort_order', 'asc');
    }
}
