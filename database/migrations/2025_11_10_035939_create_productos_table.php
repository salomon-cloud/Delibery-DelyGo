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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->integer('stock')->default(0);
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('restaurante_id'); // Usuario que es restaurante
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('tiempo_preparacion')->default(15); // minutos
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('restaurante_id')->references('id')->on('users');
            $table->index(['activo', 'categoria_id']);
            $table->index(['restaurante_id', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
