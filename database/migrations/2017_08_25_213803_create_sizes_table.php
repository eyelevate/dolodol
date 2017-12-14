<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_item_id')->nullable();
            $table->float('x_in', 5, 1)->nullable();
            $table->float('y_in', 5, 1)->nullable();
            $table->float('z_in', 5, 1)->nullable();
            $table->float('x_cm',5,1)->nullable();
            $table->float('y_cm',5,1)->nullable();
            $table->float('z_cm',5,1)->nullable();
            $table->string('name')->nullable();
            $table->decimal('subtotal',11,2)->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('sizes');
    }
}