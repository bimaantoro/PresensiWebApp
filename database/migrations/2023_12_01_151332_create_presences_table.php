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
            $table->string('employee_id');
            $table->foreign('employee_id')->references('id_employee')->on('employees')->onDelete('cascade');
            $table->char('kode_izin')->nullable();
            $table->foreign('kode_izin')->references('kode_izin')->on('pengajuan_izin')->onDelete('cascade');
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
