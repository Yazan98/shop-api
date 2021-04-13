<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('shops_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('nameAr');
            $table->string('nameEn');
            $table->string('image');
            $table->double('price');
            $table->string('descriptionAr', 300);
            $table->string('descriptionEn', 300);
            $table->string('supported_sizes');
            $table->string('supported_colors', 200);
            $table->integer('menu_id');
            $table->integer('shop_id');
            $table->boolean('is_available')->default(true);
            $table->boolean('is_enabled')->default(true);
            $table->integer('comments')->default(0);
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
        Schema::dropIfExists('shops_menu_items');
    }
}
