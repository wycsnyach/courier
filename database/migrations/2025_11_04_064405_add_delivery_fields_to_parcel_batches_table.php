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
        Schema::table('parcel_batches', function (Blueprint $table) {
            //
            $table->string('received_by_branch')->nullable();
            $table->timestamp('received_at_branch_at')->nullable();
            $table->string('delivered_by')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcel_batches', function (Blueprint $table) {
            //
        });
    }
};
