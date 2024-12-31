<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['person', 'cargo', 'entity_type', 'action', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
