<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->integer('inventory_item_id')->nullable();
            $table->integer('item_metal_id')->nullable();
            $table->integer('item_stone_id')->nullable();
            $table->integer('item_size_id')->nullable();
            $table->string('serial')->nullable();
            $table->decimal('custom_stone_price',11,2)->nullable();
            $table->integer('finger_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('subtotal',11,2)->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
}
