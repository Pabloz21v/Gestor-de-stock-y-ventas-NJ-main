<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';

    protected $fillable = [
        'name',
        'comment',
        'orden',
        'categories_id',
        'visible',
    ];

    protected $guarded = [];
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function dishes()
    {
        return $this->hasMany(Dishes::class);
    }
}
