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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('icono')->nullable();
            $table->string('color', 7)->nullable(); // Para hex colors
            $table->integer('orden')->default(0);
            $table->unsignedBigInteger('categoria_padre_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('cantidad_productos')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('categoria_padre_id')->references('id')->on('categorias');
            $table->index(['activo', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
