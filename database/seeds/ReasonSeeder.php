<?php

use App\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    const REASONS = [
        "I have paid, but I have not received the cryptocurrency.",
        "I overpaid the seller.",
        "The seller intentionally changed the advertisement price.",
        "Other issues not listed above.",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::REASONS as $item) {
            Reason::firstOrCreate([
                "name" => $item
            ]);
        }
    }
}
