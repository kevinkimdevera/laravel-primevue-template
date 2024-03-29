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
        Schema::table('users', function (Blueprint $table) {
          // Verification Code
          $table->string('verification_code')->nullable()
            ->after('remember_token');

          $table->timestamp('email_verified_at')
            ->after('verification_code')
            ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('verification_code');
          $table->dropColumn('email_verified_at');
        });
    }
};
