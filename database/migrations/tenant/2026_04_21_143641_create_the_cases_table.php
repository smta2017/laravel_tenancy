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
        Schema::create('the_cases', function (Blueprint $table) {
            $table->id('id');
            $table->string('AutoNumber')->nullable();
            $table->string('code')->nullable();
            $table->string('case_number')->nullable();
            $table->string('subject')->nullable();
            $table->foreignId('type_id')->constrained('case_types')->nullable();
            $table->foreignId('status_id')->constrained('case_states')->nullable();
            $table->foreignId('contract_id')->constrained('contracts')->nullable();
            $table->foreignId('created_by')->constrained('users')->nullable();
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
        Schema::drop('the_cases');
    }
};
