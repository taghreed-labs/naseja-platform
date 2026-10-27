<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('provider_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('requirements');
            $table->date('preferred_deadline')->nullable();

            // Snapshot of service terms at order time.
            $table->decimal('price_snapshot', 12, 2)->nullable();
            $table->string('price_type_snapshot', 50)->nullable();
            $table->string('duration_snapshot', 100)->nullable();

            $table->string('status', 30)->default('pending')->index();

            $table->timestamps();

            $table->index(['customer_id', 'created_at']);
            $table->index(['provider_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
