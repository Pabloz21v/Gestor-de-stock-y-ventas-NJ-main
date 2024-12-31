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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id')->constrained('subcategories');
            $table->string('name',255);
            $table->boolean('visible')->default(true);
            $table->text('ingredients',255)->nullable();
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('subcategory_id')
                ->references('id')->on('subcategories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
