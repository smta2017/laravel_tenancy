<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('purchase_id')->constrained();
            $table->string('name');
            $table->double('discountNet')->nullable()->default(0);
            $table->double('discount_Method')->nullable()->default(0);
            $table->double('discount')->nullable()->default(0);
            $table->double('net_cost')->nullable()->default(0);
            $table->double('unit_cost')->nullable()->default(0);
            $table->string('code')->nullable();
            $table->double('del')->nullable()->default(0);
            $table->integer('no_unit')->nullable()->default(0);
            $table->foreignId('product_id')->constrained();
            $table->foreignId('purchase_unit_id');
            $table->double('quantity')->nullable()->default(0);
            $table->double('stock')->nullable()->default(0);
            $table->double('subtotal')->nullable()->default(0);
            $table->enum('tax_type', ['inc', 'exc'])->default('inc');
            $table->integer('tax_percent')->nullable()->default(0);
            $table->double('taxe')->nullable()->default(0);
            $table->string('unitPurchase')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchase_details');
    }
};
