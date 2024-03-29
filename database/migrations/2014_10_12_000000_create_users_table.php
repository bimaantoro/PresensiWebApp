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
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 50)->primary();
            $table->string('username', 50)->unique();
            $table->string('nama_lengkap');
            $table->string('instansi', 100)->nullable();
            $table->string('start_internship')->nullable();
            $table->string('end_internship')->nullable();
            $table->string('role', 10)->default('student');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
