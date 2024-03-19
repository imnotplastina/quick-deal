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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('status');

            // Пример: 1.000.000.000,00
            $table->decimal('amount', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
