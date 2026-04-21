<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('resumen')->nullable();
            $table->longText('contenido');
            $table->string('imagen_portada')->nullable();
            $table->enum('categoria', ['lanzamiento', 'oferta', 'evento', 'general'])->default('general');
            $table->boolean('publicado')->default(false);
            $table->timestamp('publicado_en')->nullable();
            $table->boolean('destacado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
