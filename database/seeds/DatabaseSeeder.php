<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoinInfoSeeder::class);
        $this->call(FiatInfoSeeder::class);
        $this->call(ReasonSeeder::class);
    }
}
