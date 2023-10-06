<?php

namespace Database\Seeders;

use DateTime;
use DateInterval;
use App\Enum\CurrencyEnum;
use Illuminate\Support\Str;
use App\Enum\AccountTypesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a few client accounts
        $clientAccounts = [
            [
                'client_id' => 'AB23454565',
                'email' => fake()->unique()->safeEmail(),
                'client_name' => fake()->name(),
            ],
            [
                'client_id' => 'DH34454096',
                'email' => fake()->unique()->safeEmail(),
                'client_name' => fake()->name(),
            ],
            [
                'client_id' => 'SE77881100',
                'email' => fake()->unique()->safeEmail(),
                'client_name' => fake()->name(),
            ],
            [
                'client_id' => 'RT99083400',
                'email' => fake()->unique()->safeEmail(),
                'client_name' => fake()->name(),
            ],
        ];

        DB::table('clients')->insert($clientAccounts);

        $accounts = [];

        foreach ($clientAccounts as $clientAccount) {
            $accounts[] = [
                'account_id' => Str::random(10),
                'client_id' => $clientAccount['client_id'],
                'currency' => CurrencyEnum::DOLLAR,
                'account_type' => AccountTypesEnum::SAVING,
                'amount' => 1000,
                'created_at' => $this->genarateRandomDates()
            ];

            $accounts[] = [
                'account_id' => Str::random(10),
                'client_id' => $clientAccount['client_id'],
                'currency' => CurrencyEnum::EURO,
                'account_type' => AccountTypesEnum::CURRENT,
                'amount' => 3000,
                'created_at' => $this->genarateRandomDates()
            ];
        }

        DB::table('accounts')->insert($accounts);
    }

    private function genarateRandomDates(): DateTime {
        $index = rand(1,7);
        $offset = 'P'.$index.'Y'.$index.'M';
        $datetime = new DateTime('01/01/2010');
        $date = $datetime->add(new DateInterval($offset));
        logger('DateTime', [$offset, $date]);
        return $date;
    }

}
