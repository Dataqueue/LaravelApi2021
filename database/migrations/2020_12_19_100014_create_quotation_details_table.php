<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('analyse_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('description')->nullable();
            $table->string('quantity')->nullable();
            $table->string('margin')->nullable();
            $table->string('sell_price')->nullable();
            $table->string('remark')->nullable();
            $table->string('file_img_url')->nullable();
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
        Schema::dropIfExists('quotation_details');
    }
}
