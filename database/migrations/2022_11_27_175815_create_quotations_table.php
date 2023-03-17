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
            // $table->string('quotation_ref_no')->default(date('Y').random_int(100000, 999999));
            $table->string('quotation_ref_no');
            $table->string('product_id_arr');
            $table->string('quantity_arr');
            $table->integer('customer_id');
            $table->integer('currency_id');
            $table->integer('tax')->default(14);
            $table->string('status')->default('Pending');
            $table->integer('created_by');
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
