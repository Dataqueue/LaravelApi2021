<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            // $table->unsignedBigInteger('party_id')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('model_no')->nullable();
            $table->string('name_in_ar')->nullable();
            $table->text('description')->nullable();
            $table->string('unit_of_measure')->nullable();
            // $table->string('unit_price')->nullable();
            $table->string('type')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('initial_quantity')->nullable();
            $table->string('minimum_quantity')->nullable();
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
        Schema::dropIfExists('products');
    }
}
