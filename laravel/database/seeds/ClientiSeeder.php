<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();
        $clientiCount = 10;
        for ($count = 1; $count <= $clientiCount; $count++) {
            $clienti[] = [
                'id' => $count,
                'nume' => $faker->name,
                'CNP' => $faker->creditCardNumber,
                'adresa' =>$faker->address,
                'nr_telefon' =>$faker->e164PhoneNumber
            ];
        }

        DB::table('clienti')->insert($clienti);
    }

}
