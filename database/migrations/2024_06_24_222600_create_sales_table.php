<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('reg');
            $table->string('cliente');
            $table->string('contacto')->nullable();
            $table->unsignedBigInteger('vendedor')->constrained('users');
            $table->unsignedBigInteger('producto')->constrained('products');
            $table->decimal('precio', 10, 2);
            $table->integer('unidades');
            $table->decimal('entrada', 10, 2)->nullable();
            $table->decimal('pendiente', 10, 2)->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->string('estado');
            $table->decimal('sobreprecio', 10, 2)->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
}
