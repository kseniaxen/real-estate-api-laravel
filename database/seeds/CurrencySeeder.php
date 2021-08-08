<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name'=> 'грн'
        ]);
        DB::table('currencies')->insert([
            'name'=> '$'
        ]);
        DB::table('currencies')->insert([
            'name'=> '€'
        ]);
    }
}
