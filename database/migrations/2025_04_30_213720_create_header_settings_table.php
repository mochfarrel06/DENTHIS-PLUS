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
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();

            // Top Bar
            $table->string('topbar_email_icon')->default('bi-envelope');
            $table->string('topbar_email_text')->nullable();
            $table->string('topbar_email_link')->nullable();

            $table->string('topbar_phone_icon')->default('bi-phone');
            $table->string('topbar_phone_text')->nullable();
            $table->string('topbar_phone_link')->nullable();

            // Navbar
            $table->string('sitename_text')->default('DENTHIS.PLUS');
            $table->string('sitename_href')->nullable()->default('/');

            $table->json('navbar_items')->nullable(); // Menyimpan array <li> dinamis

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
