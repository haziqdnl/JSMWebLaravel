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
        Schema::dropIfExists('tb_csr_after_service_status');
        Schema::create('tb_csr_after_service_status', function (Blueprint $table) {
            $table->increments('uuid');
            $table->string('desc');
            $table->timestamps();
            $table->integer('suspend');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_csr_after_service_status');
    }
};
