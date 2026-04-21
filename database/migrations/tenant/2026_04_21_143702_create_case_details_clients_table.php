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
        Schema::create('case_details_clients', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('case_details_id')->constrained('case_details')->nullable();
            $table->foreignId('client_id')->constrained('clients')->nullable();
            $table->foreignId('attribute_opponent_id')->constrained('attribute_opponents')->nullable();
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
        Schema::drop('case_details_clients');
    }
};
