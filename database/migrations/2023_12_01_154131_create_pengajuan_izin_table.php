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
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->date('from_date_at');
            $table->date('to_date_at');
            $table->string('status', 10);
            $table->string('keterangan');
            $table->string('file_sid')->nullable();
            $table->string('status_approved', 10)->default(0);
            $table->string('employee_id');
            $table->foreign('employee_id')->references('id_employee')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};
