<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regulations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->enum('type', ['regulasi', 'publikasi'])->default('regulasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regulations');
    }
};
