<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReasonP2pTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reason_p2p_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("reason_p2p_transactions_id");
            $table->unsignedBigInteger("by_user_id");
            $table->string("description", 1000);
            $table->string("img", 1000);

            $table->foreign('reason_p2p_transactions_id', 'reason_p2p_transactions')
                ->references('id')
                ->on('reason_p2p_transactions');
            $table->foreign('by_user_id', 'rea_p2p_tran_detail_user')
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
        Schema::dropIfExists('reason_p2p_transaction_details');
    }
}
