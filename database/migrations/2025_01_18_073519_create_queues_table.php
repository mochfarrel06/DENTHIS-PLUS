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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_schedule_id')->constrained()->onDelete('cascade');

            $table->date('tgl_periksa');
            $table->time('start_time'); // Waktu mulai slot
            $table->time('end_time');   // Waktu selesai slot
            $table->string('urutan')->nullable();
            $table->string('status');
            $table->boolean('is_booked')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
