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
        Schema::dropIfExists('tb_customer_organisation');
        Schema::create('tb_customer_organisation', function (Blueprint $table) {
            $table->string('code', 10)->primary();
            $table->string('desc');
            $table->string('sdesc');
            $table->timestamps();
            $table->integer('suspend');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customer_organisation');
    }
};
