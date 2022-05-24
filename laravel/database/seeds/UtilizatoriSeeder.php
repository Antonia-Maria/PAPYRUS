<?php

use Illuminate\Database\Seeder;

class UtilizatoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker\Factory::create();
        $utilizatoriCount = 15;
        for ($count = 1; $count <= $utilizatoriCount; $count++) {
            $utilizatori[] = [
                'id' => $count,
                'Nume' => $faker->lastName,
                'Prenume' => $faker->firstName,
                'Username' => $faker->userName,
                'Parola' => $faker->password
            ];
        }

        DB::table('utilizatori')->insert($utilizatori);
    }


}
