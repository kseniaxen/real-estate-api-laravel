<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FilterTest extends DuskTestCase
{
    /**
     * Filter test for apartment with one room
     *
     * @return void
     */
    public function test_FilterApartmentWithOneRoom()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/apartment')
                ->click('#room1')
                ->click('#search')
                ->pause(3000)
                ->assertSee('1222.00 грн');
        });
    }

    /**
     * Filter test for house with three floors
     *
     * @return void
     */
    public function test_FilterHouseWith3Floors()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/house')
                ->type('#floorsFrom','3')
                ->click('#search')
                ->pause(3000)
                ->assertSee('Продам трехэтажный дом');
        });
    }
}
