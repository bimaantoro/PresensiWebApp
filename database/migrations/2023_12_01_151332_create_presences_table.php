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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('photo_in')->nullable();
            $table->string('photo_out')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->date('presence_at')->nullable();
            $table->char('presence_status', 10)->nullable();
            $table->char('employee_id')->nullable();
            $table->foreign('employee_id')->references('id_employee')->on('employees')->onDelete('cascade');
            $table->char('pengajuan_izin_id')->nullable();
            $table->foreign('pengajuan_izin_id')->references('id')->on('pengajuan_izin')->onDelete('cascade');
            $table->char('working_hour_id')->nullable();
            $table->foreign('working_hour_id')->references('id')->on('working_hours')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
