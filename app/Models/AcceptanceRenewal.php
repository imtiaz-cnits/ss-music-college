<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptanceRenewal extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'date', 'description', 'file'];

    protected $casts = [
        'date' => 'date',
    ];
}
