<?php

use Illuminate\Database\Seeder;

class TypePropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_properties')->insert([
            'name'=> 'Квартира'
        ]);
        DB::table('type_properties')->insert([
            'name'=> 'Дом'
        ]);
    }
}
