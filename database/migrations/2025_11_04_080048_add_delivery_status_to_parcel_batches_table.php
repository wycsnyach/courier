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
        Schema::table('parcel_batches', function (Blueprint $table) {
            $table->boolean('is_delivered')->default(false);
            // Optionally track when delivered
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
