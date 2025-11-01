<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->cascade()->onDelete('cascade');
            $table->foreignId('item_id')->cascade()->onDelete('cascade');
            $table->foreignId('shipping_address_id')->cascade()->onDelete('cascade');
            $table->tinyInteger('payment_method')->comment('支払方法:1=コンビニ支払い、2=カード支払い');
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
        Schema::dropIfExists('purchases');
    }
}
