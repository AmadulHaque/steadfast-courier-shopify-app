<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Osiset\ShopifyApp\Storage\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //basic plan
        Plan::create([
            'type' => 'RECURRING',
            'name' => 'Basic',
            'price' => 9.90,
            'interval' => 'EVERY_30_DAYS',
            'capped_amount' => 0,
            "terms" => "Terms",
            "trial_days" => 7,
            "test" => 0,
            "on_install" => 0,
        ]);

        // Premium plan
        Plan::create([
            'type' => 'RECURRING',
            'name' => 'Premium',
            'price' => 19.90,
            'interval' => 'EVERY_30_DAYS',
            'capped_amount' => 0,
            "terms" => "Terms",
            "trial_days" => 7,
            "test" => 0,
            "on_install" => 0,
        ]);

        // Enterprise plan
        Plan::create([
            'type' => 'RECURRING',
            'name' => 'Enterprise',
            'price' => 29.90,
            'interval' => 'EVERY_30_DAYS',
            'capped_amount' => 0,
            "terms" => "Terms",
            "trial_days" => 7,
            "test" => 0,
            "on_install" => 0,
        ]);

    }
}
