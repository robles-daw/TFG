<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_alert_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('zapatilla_id')->constrained('zapatillas')->cascadeOnDelete();
            $table->decimal('talla', 4, 1);
            $table->string('email');
            $table->timestamps();

            $table->unique(['user_id', 'zapatilla_id', 'talla'], 'stock_alert_unique_subscription');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_alert_subscriptions');
    }
};
