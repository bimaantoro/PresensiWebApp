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
        Schema::create('working_hours', function (Blueprint $table) {
            $table->char('id', 50)->primary();
            $table->string('name', 50)->nullable();
            $table->time('start_check_in')->nullable();
            $table->time('jam_in')->nullable();
            $table->time('end_check_in')->nullable();
            $table->time('jam_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
