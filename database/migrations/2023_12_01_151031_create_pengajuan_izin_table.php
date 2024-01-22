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
            $table->char('kode_izin', 50)->primary();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('file_surat_dokter')->nullable();
            $table->string('status', 10);
            $table->string('status_code', 5)->default(0);
            $table->smallInteger('jumlah_hari')->nullable();
            $table->string('keterangan_izin')->nullable();
            $table->string('keterangan_penolakan')->nullable();
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
