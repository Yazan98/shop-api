<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('nameAr');
            $table->string('nameEn');
            $table->string('shortDescriptionAr', 150);
            $table->string('shortDescriptionEn', 150);
            $table->string('descriptionAr', 250);
            $table->string('descriptionEn', 250);
            $table->string('image', 250)->default("");
            $table->string('locationAr');
            $table->integer('created_by')->default(-1);
            $table->string('locationEn');
            $table->boolean('is_enabled')->default(true);
            $table->double('location_lat')->default(0.0);
            $table->double('location_lng')->default(0.0);
            $table->boolean('is_open_everyday')->default(false);
            $table->string('cover', 250)->default("");
            $table->boolean('discount_supported')->default(false);
            $table->double('delivery_fee')->default(0.0);
            $table->float('rating')->default(0.0);
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
        Schema::dropIfExists('shops');
    }
}
