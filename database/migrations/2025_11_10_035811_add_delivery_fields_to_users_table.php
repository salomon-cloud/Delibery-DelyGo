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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('tipo_usuario', ['cliente', 'restaurante', 'repartidor', 'admin'])
                  ->default('cliente')->after('email');
            $table->string('telefono')->nullable()->after('tipo_usuario');
            $table->text('direccion')->nullable()->after('telefono');
            $table->boolean('activo')->default(true)->after('direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tipo_usuario', 'telefono', 'direccion', 'activo']);
        });
    }
};
