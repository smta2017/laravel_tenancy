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
        Schema::create('case_detail_events', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('case_details_id')->nullable()->constrained('case_details');
            $table->foreignId('parent_id')->nullable()->constrained('case_detail_events');
            $table->string('subject')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('event_types');
            $table->foreignId('status_id')->nullable()->constrained('event_states');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('closed_by')->nullable()->constrained('users');
            $table->boolean('is_private');
            $table->boolean('client_access');
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
        Schema::drop('case_detail_events');
    }
};
