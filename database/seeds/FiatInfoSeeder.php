<?php

use App\Models\FiatInfo;
use Illuminate\Database\Seeder;

class FiatInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config("services.fiat_infos") as $fiatInfo) {
            FiatInfo::updateOrCreate($fiatInfo[0], $fiatInfo[1]);
        }
    }
}
