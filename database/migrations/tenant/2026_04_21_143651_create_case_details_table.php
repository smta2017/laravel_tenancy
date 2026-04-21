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
        Schema::create('case_details', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('case_id')->constrained('the_cases')->nullable();
            $table->foreignId('litigation_level_id')->constrained('litigation_levels')->nullable();
            $table->string('case_number')->nullable();
            $table->string('circle')->nullable();
            $table->string('floor')->nullable();
            $table->string('hall')->nullable();
            $table->string('secretary')->nullable();
            $table->foreignId('litigation_authority_id')->constrained('litigation_authorities')->nullable();
            $table->string('gedge')->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::drop('case_details');
    }
};
