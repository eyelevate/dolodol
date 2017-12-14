<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->decimal('subtotal',11,2)->nullable();
            $table->boolean('taxable')->default(1);
            $table->boolean('active')->default(0);
            $table->boolean('featured')->default(0);
            $table->boolean('sizes')->default(0);
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
        Schema::dropIfExists('inventory_items');
    }
}
