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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('restaurante_id');
            $table->unsignedBigInteger('repartidor_id')->nullable();
            $table->enum('estado', ['recibida', 'preparando', 'en_camino', 'entregada', 'cancelada'])
                  ->default('recibida');
            $table->decimal('total', 10, 2);
            $table->text('direccion_entrega');
            $table->string('telefono_contacto');
            $table->text('notas')->nullable();
            $table->integer('tiempo_estimado')->nullable(); // minutos
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('users');
            $table->foreign('restaurante_id')->references('id')->on('users');
            $table->foreign('repartidor_id')->references('id')->on('users');
            $table->index(['estado', 'created_at']);
            $table->index(['cliente_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
