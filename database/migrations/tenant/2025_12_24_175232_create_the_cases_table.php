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
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('case_number')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->nullable();
            $table->string('subject')->nullable();
            $table->string('court')->nullable();
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
