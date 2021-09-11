<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Login test
     *
     * @return void
     */
    public function test_Login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/signin')->assertSee('Вход')
                ->type('#email', 'user@user.com')
                ->type('#password', 'user')
                ->click('#button')
                ->pause(5000)
                ->assertPathIs('/');
        });
    }
}
