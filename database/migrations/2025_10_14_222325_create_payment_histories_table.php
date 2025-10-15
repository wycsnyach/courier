<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->decimal('amount_paid', 10, 2);
            $table->unsignedBigInteger('payment_mode_id');
            $table->string('transaction_reference')->nullable();
            $table->timestamp('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('payment_mode_id')->references('id')->on('paymentmodes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};