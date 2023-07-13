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
        Schema::dropIfExists('tb_csr');
        Schema::create('tb_csr', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->integer('customer_id')->unsigned();
            $table->integer('service_type')->unsigned();
            $table->string('service_type_other');
            $table->integer('contract_type')->unsigned();
            $table->timestamp('instruction_date')->nullable();
            $table->string('report_desc');
            $table->string('asset_serial_no', 20);
            $table->integer('staff_id')->unsigned();
            $table->timestamp('report_date')->nullable();
            $table->string('service_desc');
            $table->timestamp('service_date')->nullable();
            $table->timestamp('service_start_at')->nullable();
            $table->timestamp('service_end_at')->nullable();
            $table->integer('after_service_status')->unsigned();
            $table->integer('charge_status');
            $table->integer('charge_mileage');
            $table->integer('charge_travel_hr');
            $table->integer('charge_travel_min');
            $table->timestamps();

            $table->foreign('customer_id')->references('uuid')->on('tb_customer')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_type')->references('uuid')->on('tb_csr_service_type')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_type')->references('uuid')->on('tb_csr_contract_type')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asset_serial_no')->references('serial_no')->on('tb_asset')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('staff_id')->references('uuid')->on('tb_staff')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('after_service_status')->references('uuid')->on('tb_csr_after_service_status')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_csr');
    }
};
