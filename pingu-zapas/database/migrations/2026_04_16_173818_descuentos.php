<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['porcentaje', 'fijo'])->default('porcentaje');
            $table->decimal('valor', 8, 2);
            $table->decimal('minimo_pedido', 8, 2)->nullable();
            $table->decimal('maximo_descuento', 8, 2)->nullable();
            $table->unsignedInteger('usos_maximos')->nullable();
            $table->unsignedInteger('usos_actuales')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
