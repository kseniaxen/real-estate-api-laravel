<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * Register test
     *
     * @return void
     */
    public function test_Register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/signup')->assertSee('Регистрация')
                ->type('#name', 'name')
                ->type('#email', 'name@name.com')
                ->type('#password', 'password')
                ->click('#button')
                ->pause(3000)
                ->assertSee('Приветствуем!');
        });
    }
}
