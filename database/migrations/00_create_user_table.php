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
        Schema::dropIfExists('tb_user');
        Schema::create('tb_user', function (Blueprint $table) {
            $table->increments('uuid');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 70);
            $table->integer('otp', 6)->nullable();
            $table->timestamp('otp_expired_at')->nullable();
            $table->string('token')->unique()->nullable();
            $table->timestamp('token_expired_at')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamps();
            $table->integer('suspend', 1)->default(0)->comment("0=Active; 1=Suspend");
            $table->morphs('profile');
            //$table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
