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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('site_name')->nullable()->default('CMS');
            $table->string('description')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('name_gubernur')->nullable();
            $table->string('position_gubernur')->nullable();
            $table->string('photo_gubernur')->nullable();
            $table->string('name_wakil_gubernur')->nullable();
            $table->string('position_wakil_gubernur')->nullable();
            $table->string('photo_wakil_gubernur')->nullable();
            $table->text('welcome_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
