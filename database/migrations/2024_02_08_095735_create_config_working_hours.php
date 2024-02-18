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
        Schema::create('config_working_hours', function (Blueprint $table) {
            $table->id();
            $table->string('day', 50)->nullable();
            $table->char('employee_id')->nullable();
            $table->foreign('employee_id')->references('id_employee')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('config_working_hours');
    }
};
