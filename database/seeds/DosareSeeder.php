<?php

use Illuminate\Database\Seeder;

class DosareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $dosareCount = 20;
        for ($count = 1; $count <= $dosareCount; $count++) {
            $dosare[] = [
                'id' => $count,
                'data_inregistrare' => $faker->dateTime,
                'informatii' => $faker->realText
            ];
        }

        DB::table('dosare')->insert($dosare);
    }

}
