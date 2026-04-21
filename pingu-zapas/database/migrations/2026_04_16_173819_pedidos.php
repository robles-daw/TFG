<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('descuento_id')->nullable()->constrained('descuentos')->nullOnDelete();
            $table->string('numero_pedido', 20)->unique();
            $table->enum('estado', ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento_aplicado', 8, 2)->default(0);
            $table->decimal('gastos_envio', 6, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('nombre_envio');
            $table->text('direccion_envio');
            $table->string('ciudad_envio', 100);
            $table->string('codigo_postal_envio', 10);
            $table->string('pais_envio', 100)->default('España');
            $table->string('telefono_contacto', 20)->nullable();
            $table->enum('metodo_pago', ['tarjeta', 'paypal', 'transferencia', 'contrareembolso'])->default('tarjeta');
            $table->string('referencia_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
