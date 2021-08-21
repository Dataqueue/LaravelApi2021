<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('po_number')->nullable();
            $table->string('status')->default('New');
            $table->string('issue_date')->nullable();
            $table->string('total_value')->nullable();
            $table->string('discount_in_percentage')->nullable();
            $table->string('vat_in_value')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('delivery_no')->nullable();
            $table->string('payment_type')->nullable();
            $table->unsignedBigInteger('party_id')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
