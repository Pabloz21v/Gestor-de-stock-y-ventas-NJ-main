<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
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
        'video',
        'proveedores',
    ];

    protected $guarded = [];

    protected $casts = [
        'imagenes' => 'array',
    ];
    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }
    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class);
    }

    
    // Relación para obtener la URL delvideo
    public function getVideoUrlAttribute()
    {
        return $this->video ? Storage::url($this->video) : null;
    }
    
    // Relación para obtener la URL de la foto principal
    public function getImagenPrincipalUrlAttribute()
    {
        return $this->imagen_principal ? Storage::url($this->imagen_principal) : null;
    }
    // Relación para obtener las URLs de las fotos extra
    public function getImagenesUrlAttribute()
    {
        return array_map(function ($photo) {
            return Storage::url($photo);
        }, $this->imagenes ?? []);
    }

    // Método para eliminar la foto principal
    public function deleteImagenPrincipal()
    {
        if ($this->imagen_principal) {
            Storage::delete($this->imagen_principal);
            $this->imagen_principal = null;
            $this->save();
        }
    }

    // Método para eliminar elvideo
    public function deleteVideo()
    {
        if ($this->video) {
            Storage::delete($this->video);
            $this->video = null;
            $this->save();
        }
    }

    // Método para eliminar una foto extra
    public function deleteImagenes($index)
    {
        $imagenes = $this->imagenes;
        if (isset($imagenes[$index])) {
            Storage::delete($imagenes[$index]);
            unset($imagenes[$index]);
            $this->imagenes = json_encode(array_values($imagenes));
            $this->save();
        }
    }
}
