<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg',
        'fecha',
        'cliente',
        'contacto',
        'vendedor',
        'producto',
        'precio',
        'unidades',
        'entrada',
        'pendiente',
        'sub_total',
        'estado',
        'sobreprecio',
        'observacion',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'producto');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'vendedor');
    }
}
