<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pCoinFiatPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_coin_fiat_pairs', function (Blueprint $table) {
            $table->id();
            $table->char('coin_currency', 20);
            $table->char('fiat_currency', 20);
            $table->foreign('coin_currency')
                ->references('currency')
                ->on('coin_infos');
            $table->foreign('fiat_currency')
                ->references('currency')
                ->on('fiat_infos');
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
        Schema::dropIfExists('p2p_coin_fiat_pairs');
    }
}
