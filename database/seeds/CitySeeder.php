<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = array
        ('Мариуполь'
        ,'Киев'
        ,'Харьков'
        ,'Одесса'
        );

        $countriesId = array(1);

        foreach ($cities as $city){
            DB::table('cities')->insert(
                [
                    'name'=> $city,
                    'countryId' => $countriesId[0]
                ]
            );
        }
    }
}
