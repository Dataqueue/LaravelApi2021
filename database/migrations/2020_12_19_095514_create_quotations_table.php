<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_no')->nullable()->default(0);
            $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('rfq_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('status')->default('New');
            $table->string('total_value')->nullable();
            $table->string('discount_in_p')->nullable();
            $table->string('vat_in_value')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('validity')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('warranty')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('inco_terms')->nullable();
            $table->string('po_number')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('ps_date')->nullable();
            $table->string('sales_order_number')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_revised')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
