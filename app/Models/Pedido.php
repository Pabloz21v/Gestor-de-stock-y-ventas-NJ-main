<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'product_id',
        'stock_real',
        'stock_en_viaje',
        'stock_en_viaje_vendido',
        'proveedor',
        'web',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

        // Eventos del modelo con transacciones
        protected static function booted()
        {
            static::created(function (Pedido $pedido) {
                DB::transaction(function () use ($pedido) {
                    $product = $pedido->product;
                    $product->increment('stock_real', $pedido->stock_real);
                    $product->increment('stock_en_viaje', $pedido->stock_en_viaje);
                    $product->increment('stock_en_viaje_vendido', $pedido->stock_en_viaje_vendido);
                });
            });
    
            static::updated(function (Pedido $pedido) {
                DB::transaction(function () use ($pedido) {
                    $product = $pedido->product;
                    
                    // Calcular diferencias
                    $diffStockReal = $pedido->stock_real - $pedido->getOriginal('stock_real');
                    $diffStockViaje = $pedido->stock_en_viaje - $pedido->getOriginal('stock_en_viaje');
                    $diffStockViajeVendido = $pedido->stock_en_viaje_vendido - $pedido->getOriginal('stock_en_viaje_vendido');
    
                    // Aplicar cambios al producto
                    $product->increment('stock_real', $diffStockReal);
                    $product->increment('stock_en_viaje', $diffStockViaje);
                    $product->increment('stock_en_viaje_vendido', $diffStockViajeVendido);
                });
            });
    
            static::deleted(function (Pedido $pedido) {
                DB::transaction(function () use ($pedido) {
                    $product = $pedido->product;
                    $product->decrement('stock_real', $pedido->stock_real);
                    $product->decrement('stock_en_viaje', $pedido->stock_en_viaje);
                    $product->decrement('stock_en_viaje_vendido', $pedido->stock_en_viaje_vendido);
                });
            });
        }
    
}
