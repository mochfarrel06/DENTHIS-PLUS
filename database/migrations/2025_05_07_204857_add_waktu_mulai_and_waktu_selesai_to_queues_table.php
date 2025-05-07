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
        Schema::table('queues', function (Blueprint $table) {
            $table->time('waktu_mulai')->nullable()->after('end_time');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
        });
    }
};
