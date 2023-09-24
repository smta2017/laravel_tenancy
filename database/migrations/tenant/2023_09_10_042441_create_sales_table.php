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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('id');
            $table->double('grand_total')->nullable()->default(0);
            $table->double('tax_net')->nullable()->default(0);
            $table->date('the_date');
            $table->double('discount')->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->double('shipping')->nullable()->default(0);
            $table->foreignId('status_id')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->double('tax_rate')->nullable()->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users');
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
        Schema::drop('sales');
    }
};
