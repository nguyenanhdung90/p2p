<?php

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::updateOrCreate(
            [
                "user_name" => "user_1",
                "currency" => "TON",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_1",
                "currency" => "USDT",
            ],
            [
                "amount" => 600000000,
                "p2p_amount" => 500000000,
                "locked_amount" => 10000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_1",
                "currency" => "NOT",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_1",
                "currency" => "PAYN",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_1",
                "currency" => "BTC",
            ],
            [
                "amount" => 50000000000,
                "p2p_amount" => 40000000000,
                "locked_amount" => 1000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_2",
                "currency" => "TON",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_2",
                "currency" => "USDT",
            ],
            [
                "amount" => 600000000,
                "p2p_amount" => 500000000,
                "locked_amount" => 10000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_2",
                "currency" => "NOT",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_2",
                "currency" => "PAYN",
            ],
            [
                "amount" => 300000000000,
                "p2p_amount" => 200000000000,
                "locked_amount" => 10000000000,
            ]
        );
        Wallet::updateOrCreate(
            [
                "user_name" => "user_2",
                "currency" => "BTC",
            ],
            [
                "amount" => 50000000000,
                "p2p_amount" => 40000000000,
                "locked_amount" => 1000000000,
            ]
        );
    }
}
