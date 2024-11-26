<?php

use App\Models\P2pAd;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("fiat_price");
            $table->char("fiat_currency", 20);
            $table->unsignedBigInteger("coin_amount");
            $table->char("coin_currency", 20);
            $table->unsignedBigInteger("coin_minimum_amount");
            $table->unsignedBigInteger("coin_maximum_amount");
            $table->enum("type", ["SELL", "BUY"]);
            $table->unsignedBigInteger("user_id");
            $table->enum("payment_method", [P2pAd::BANK_TRANSFER]);
            $table->unsignedBigInteger("bank_transfer_detail_id")->nullable();
            $table->boolean("is_active")->default(1);
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
        Schema::dropIfExists('p2p_ads');
    }
}
