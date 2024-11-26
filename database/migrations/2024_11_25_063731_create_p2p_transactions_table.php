<?php

use App\Models\P2pTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_transactions', function (Blueprint $table) {
            $table->id();
            $table->char("reference", 36)->unique();
            $table->unsignedBigInteger("p2p_ad_id");
            $table->unsignedBigInteger("partner_user_id");
            $table->unsignedBigInteger("coin_amount");
            $table->unsignedBigInteger("expired_process");
            $table->timestamp("start_process");
            $table->timestamp("end_process")->nullable();
            $table->enum("status", [P2pTransaction::INITIATE, P2pTransaction::PARTNER_TRANSFER,
                P2pTransaction::SUCCESS, P2pTransaction::CANCEL, P2pTransaction::CLAIM_FAILED_PAYMENT])
                ->default(P2pTransaction::INITIATE);

            $table->foreign('p2p_ad_id')
                ->references('id')
                ->on('p2p_ads');
            $table->foreign('partner_user_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('p2p_transactions');
    }
}
