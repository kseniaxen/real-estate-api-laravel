<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name'=> 'соток'
        ]);
        DB::table('units')->insert([
            'name'=> 'гектар'
        ]);
        DB::table('units')->insert([
            'name'=> 'кв. м'
        ]);
    }
}
