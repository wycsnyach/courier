<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('batch_delivery_histories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('batch_id');
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('action'); // e.g. Delivered to Branch / Received by Recipient
        $table->string('location')->nullable(); // optional
        $table->timestamp('action_time')->nullable();
        $table->text('remarks')->nullable();
        $table->string('signature_path')->nullable(); // for recipient signature if any
        $table->timestamps();

        $table->foreign('batch_id')->references('id')->on('parcel_batches')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_delivery_histories');
    }
};
