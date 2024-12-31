<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'name',
        'ingredients',
        'price',
        'subcategory_id',
        'visible',
    ];

    protected $guarded = [];

    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
