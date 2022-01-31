<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'audience_can_join' => 'boolean'
    ];
}
