<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable()->constrained('categories');
            $table->unsignedBigInteger('subcategory_id')->nullable()->constrained('subcategories');
            $table->boolean('visible')->default(true);

            // DINERO
            $table->decimal('price', 10, 2); //precio base del producto
            $table->decimal('ganancia', 10, 2)->nullable()->default(0); // % deseado de ganancia
            $table->decimal('descuento', 5, 2)->nullable()->default(0); // % de descuento
            $table->boolean('oferta')->default(false); // booleano para indicar que se aplica el descuento

            // caracteristicas del producto
            $table->string('name', 255); //nombre producto
            $table->text('description', 255)->nullable();
            $table->text('detalles')->nullable();
            $table->string('marca')->nullable();
            $table->string('tamaño')->nullable();
            $table->string('color')->nullable();
            $table->string('peso')->nullable();
            $table->text('dimensiones')->nullable();

            //STOCK
            $table->integer('stock')->default(0); // si se pide mas de lo que se tiene de stock_real
            $table->integer('contador_ventas')->default(0); // cuenta las ventas realizadas del producto
            $table->integer('stock_real')->default(0);  //el que se tiene a disposicion
            $table->integer('stock_minimo')->default(0); //alertas de poco stock
            $table->integer('stock_maximo')->default(0); //alertas de sobreestock

            // imagenes videos proveedores
            $table->string('imagen_principal')->nullable(); // URL de la imagen principal
            $table->json('imagenes')->nullable();
            $table->string('video')->nullable(); // URL delvideo de presentación
            $table->string('proveedores')->nullable(); //   almacenar múltiples proveedores con sus URLs

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subcategory_id')
                ->references('id')->on('subcategories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->decimal('calificacion_promedio', 2, 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
