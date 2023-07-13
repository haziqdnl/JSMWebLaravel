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
        Schema::dropIfExists('tb_customer');
        Schema::create('tb_customer', function (Blueprint $table) {
            $table->increments('uuid');
            $table->string('email')->unique();
            $table->string('mobile_no', 15)->unique();
            $table->string('fullname');
            $table->string('branch_code', 20);
            $table->timestamps();
            $table->integer('suspend');

            $table->foreign('branch_code')->references('code')->on('tb_customer_branch')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customer');
    }
};
