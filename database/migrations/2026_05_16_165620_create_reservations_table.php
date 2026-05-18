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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');
            $table->string('phone');

            $table->date('check_in');
            $table->date('check_out');

            $table->integer('total_price');

            $table->json('facilities')->nullable();

            $table->enum('status', [
                'dipesan',
                'check_in',
                'check_out',
                'dibatalkan'
            ])->default('dipesan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
