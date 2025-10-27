<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 100)->unique();
            $table->text('sender_name');
            $table->text('sender_address')->nullable();
            $table->text('sender_contact');
            $table->text('recipient_name');
            $table->text('recipient_address')->nullable();
            $table->text('recipient_contact');
            $table->tinyInteger('type')->comment('1 = Deliver, 2 = Pickup');
            $table->unsignedBigInteger('from_branch_id');
            $table->unsignedBigInteger('to_branch_id');
            $table->string('weight', 100)->nullable();
            $table->string('height', 100)->nullable();
            $table->string('width', 100)->nullable();
            $table->string('length', 100)->nullable();
            $table->float('quantity');
            $table->float('unit_price');
            $table->float('price');
            $table->tinyInteger('status')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('from_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
