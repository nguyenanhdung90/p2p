<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pTransactionsChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_transactions_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("p2p_transaction_id");
            $table->unsignedBigInteger("by_user_id");
            $table->unsignedBigInteger("user_chat_id");
            $table->text("data");

            $table->foreign('p2p_transaction_id', 'p2p_transaction_chat')
                ->references('id')
                ->on('p2p_transactions');
            $table->foreign('by_user_id')
                ->references('id')
                ->on('users');
            $table->foreign('user_chat_id')
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
        Schema::dropIfExists('p2p_transactions_chats');
    }
}
