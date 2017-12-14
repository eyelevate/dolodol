<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->boolean('active')->default(0);
            $table->string('img_src')->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->string('featured_src')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collection_item', function (Blueprint $table) {
            $table->integer('collection_id');
            $table->integer('inventory_item_id');
            $table->primary(['collection_id','inventory_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('collection_item');
    }
}
