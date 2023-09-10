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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->double('tax')->nullable();
            $table->enum('tax_type', ['inc', 'exc'])->default('inc');
            $table->string('description')->nullable();
            $table->enum('type', ['standerd', 'variable', 'service'])->default('standerd');
            $table->double('cost')->default(0);
            $table->double('price')->default(0);
            $table->foreignId('unit_id')->constrained()->nullable();
            $table->foreignId('sale_unit_id')->nullable();
            $table->foreignId('purchase_unit_id')->nullable();
            $table->integer('stok_alert')->nullable();
            $table->boolean('has_serial')->nullable();
            $table->boolean('not_for_sale')->nullable();
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
        Schema::drop('products');
    }
};
