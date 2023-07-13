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
        Schema::dropIfExists('tb_asset');
        Schema::create('tb_asset', function (Blueprint $table) {
            $table->string('serial_no', 20)->primary();
            $table->string('model');
            $table->string('location_desc');
            $table->integer('type');
            $table->integer('down_status');
            $table->string('branch_code', 20);
            $table->timestamps();

            $table->foreign('branch_code')->references('code')->on('tb_customer_branch')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_asset');
    }
};
