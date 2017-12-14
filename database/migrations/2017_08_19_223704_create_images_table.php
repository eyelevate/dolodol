<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id')->nullable();
            $table->integer('inventory_item_id')->nullable();
            $table->boolean('primary')->default(0);
            $table->boolean('featured')->default(0);
            $table->string('img_src')->nullable();
            $table->string('featured_src')->nullable();
            $table->integer('ordered')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('images');
    }
}
