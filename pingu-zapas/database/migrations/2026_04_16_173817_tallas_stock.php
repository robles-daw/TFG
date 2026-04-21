<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tallas_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zapatilla_id')->constrained('zapatillas')->cascadeOnDelete();
            $table->decimal('talla', 4, 1);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            $table->unique(['zapatilla_id', 'talla']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tallas_stock');
    }
};
