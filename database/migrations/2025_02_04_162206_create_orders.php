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
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('fake_user')->nullable();

            $table->string('order_code', 10)->unique();
            $table->enum('status', ['unconfirmed', 'confirmed', 'shipping', 'delivered', 'completed',
                        'canceled', 'failed', 'returning', 'returned'])->default('unconfirmed');
            $table->string('payment_method');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded', 'cancel'])->default('unpaid');
            $table->string('address');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone_number');
            $table->text('note')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('total_final', 10, 2);
            $table->double('discount_amount', 10, 2)->default(0);
            $table->double('shipping', 10, 2)->nullable();
            $table->text('reason_cancel')->nullable();
            $table->text('reason_failed')->nullable();
            $table->text('reason_returned')->nullable();
            $table->timestamps();
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
