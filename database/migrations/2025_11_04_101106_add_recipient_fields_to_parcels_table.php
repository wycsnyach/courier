<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->timestamp('recipient_collected_at')->nullable()->after('description');
            $table->string('collected_by')->nullable()->after('recipient_collected_at');
            $table->string('recipient_signature')->nullable()->after('collected_by');
        });
    }

    public function down()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn(['recipient_collected_at', 'collected_by', 'recipient_signature']);
        });
    }
};
