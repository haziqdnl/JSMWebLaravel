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
        Schema::create('tb_csr_spare_part', function (Blueprint $table) {
            $table->increments('uuid');
            $table->string('serial_no');
            $table->string('desc');
            $table->integer('qty');
            $table->double('amount', 8, 2);
            $table->string('revision_level');
            $table->string('csr_id');
            $table->timestamps();

            $table->foreign('csr_id')->references('uuid')->on('tb_csr')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_csr_spare_part');
    }
};
