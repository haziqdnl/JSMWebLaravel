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
        Schema::dropIfExists('tb_customer_branch');
        Schema::create('tb_customer_branch', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('org_code', 10);
            $table->string('address1');
            $table->string('address2');
            $table->integer('postcode');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->timestamps();
            $table->integer('suspend');

            $table->foreign('org_code')->references('code')->on('tb_customer_organisation')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customer_branch');
    }
};
