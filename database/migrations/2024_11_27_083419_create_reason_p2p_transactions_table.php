<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReasonP2pTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reason_p2p_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("reason_id");
            $table->unsignedBigInteger("p2p_transaction_id");
            $table->unsignedBigInteger("by_user_id");
            $table->enum("status", ["PENDING", "FAILED", "SUCCESS", "RESOLVED"]);

            $table->foreign('reason_id', 'reasons')
                ->references('id')
                ->on('reasons');
            $table->foreign('p2p_transaction_id', 'p2p_transactions')
                ->references('id')
                ->on('p2p_transactions');
            $table->foreign('by_user_id', 'rea_p2p_tran_user')
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
        Schema::dropIfExists('reason_p2p_transactions');
    }
}
