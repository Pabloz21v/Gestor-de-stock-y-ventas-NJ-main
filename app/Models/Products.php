<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'codigo',
        'category_id',
        'subcategory_id',
        'visible',
        'price',
        'ganancia',
        'descuento',
        'oferta',
        'name',
        'description',
        'detalles',
        'marca',
        'tamaño',
        'color',
        'peso',
        'dimensiones',
        'stock',
        'contador_ventas',
        'stock_real',
        'stock_minimo',
        'stock_maximo',
        'imagen_principal',
        'imagenes',
        'video_url',
        'proveedores',
    ];

    protected $guarded = [];

    protected $casts = [
        'imagenes' => 'array',
        'dimensiones' => 'array',
        'proveedores' => 'array',
    ];
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }
    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
