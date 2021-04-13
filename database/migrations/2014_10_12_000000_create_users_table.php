<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::defaultStringLength(191);
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->default("NOT_SELECTED");
            $table->string('security_question')->nullable();
            $table->string('security_question_answer')->nullable();
            $table->string('type')->default("USER");
            $table->string('status')->default("NOT_VERIFIED");
            $table->string('image', 200)->nullable();
            $table->integer('age');
            $table->boolean('is_account_activated')->default(false);
            $table->boolean('is_account_enabled')->default(false);
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->double('location_lat');
            $table->double('location_lng');
            $table->string('location_name');
            $table->boolean('is_enabled')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
