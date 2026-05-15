<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('signer_name')->nullable();
            $table->string('signer_position')->nullable();
            $table->string('signer_nip')->nullable();
            $table->string('sign_location')->nullable();
            $table->boolean('use_digital_signature')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['signer_name', 'signer_position', 'signer_nip', 'sign_location', 'use_digital_signature']);
        });
    }
};
