<?php

namespace Modules\Pricing\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Pricing\Entities\Currency;

class PricingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Currency::create([
            "name" => "US Dollar",
            "code" => "USD",
        ]);
        Currency::create([
            "name" => "CANADA Dollar",
            "code" => "CAD",
        ]);
        Currency::create([
            "name" => "Australian Dollar",
            "code" => "AUD",
        ]);

        Currency::create([
            "name" => "British Pound",
            "code" => "GBP",
        ]);

        Currency::create([
            "name" => "European Euro",
            "code" => "EUR",
        ]);

        Currency::create([
            "name" => "Swiss Franc",
            "code" => "CHF",
        ]);


        Currency::create([
            "name" => "Iran Rial",
            "code" => "IRR",
        ]);

        // $this->call("OthersTableSeeder");
    }
}
