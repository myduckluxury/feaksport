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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['fixed', 'percentage']);
            $table->enum('kind', ['total', 'shipping']);
            $table->string('code')->unique();
            $table->decimal('value', 10, 2);
            $table->integer('quantity');
            $table->decimal('min_total', 10, 2);
            $table->decimal('max_discount', 10, 2);
            $table->date('start_date');
            $table->date('expiration_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
