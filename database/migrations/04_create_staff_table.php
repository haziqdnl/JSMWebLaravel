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
        Schema::dropIfExists('tb_staff');
        Schema::create('tb_staff', function (Blueprint $table) {
            $table->increments('uuid');
            $table->string('email')->unique();
            $table->string('mobile_no', 15)->unique();
            $table->string('fullname');
            $table->integer('sex', 1)->comment("0=Female; 1=Male");
            $table->date('birthdate');
            $table->string('address1');
            $table->string('address2');
            $table->integer('postcode', 5);
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->timestamps();
            $table->integer('suspend', 1)->default(0)->comment("0=Active; 1=Suspend");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_staff');
    }
};
