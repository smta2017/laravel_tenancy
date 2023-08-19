<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->default('users/default.png');
            $table->string('password');
            $table->string('global_id')->nullable()->unique();
            $table->rememberToken();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mob', 20)->nullable();
            $table->integer('nationalitie_id')->nullable();
            $table->date('d_o_b')->nullable();
            $table->string('job', 100)->nullable();
            $table->string('website', 200)->nullable();
            $table->string('photo', 200)->nullable();
            $table->integer('is_active')->nullable();
            $table->string('active_token')->nullable();
            $table->integer('is_approved')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_admin')->nullable();
            $table->integer('is_owner')->nullable();
            $table->integer('covenantAccount_id')->nullable();
            $table->integer('requestaccount_id')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('last_login_location', 150)->nullable();
            $table->dateTime('logout_at')->nullable();
            $table->string('default_language', 2)->nullable();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
