<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CountryControllerResponseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_givenCountryUrlWithCorrectCredentialsWhenCountryThenReturnCreatedStatus()
    {
        $faker = Faker::create('App\Models\Country');
        $response = $this->postJson('/api/country', ['name' => $faker->name()]);
        $response
            ->assertCreated()
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function test_givenCountryUrlWithNoCorrectCredentialsWhenCountryThenReturnBadRequestStatus()
    {
        $response = $this->postJson('/api/country', ['name' => '']);
        $response
            ->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'name'=>[
                        "The name field is required."
                    ]
                ]]);
    }

    public function test_givenCountryUrlWithTakenNameCountryWhenCountryThenReturnBadRequestStatus()
    {
        $response = $this->postJson('/api/country', ['name' => 'Украина']);
        $response
            ->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'name'=>[
                        "The name has already been taken."
                    ]
                ]]);
    }

    public function test_givenCountryUrlWithCorrectCredentialsWhenCountryEditThenReturnOkStatus()
    {
        $response = $this->patchJson('/api/country/2', ['name' => 'Беларусь']);
        $response
            ->assertOk()
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function test_givenCountryUrlWithCorrectCredentialsWhenCountryDeleteThenReturnNoContentStatus()
    {
        $response = $this->delete('/api/country/2');
        $response
            ->assertNoContent();
    }

    public function test_givenCountryUrlWhenCountryThenReturnCountriesWithOkStatus()
    {
        $response = $this->get('/api/country');
        $response->assertJsonCount(1, 'data');
    }

    public function test_givenCountryUrlWhenCountryThenReturnCountryWithOkStatus()
    {
        $response = $this->get('/api/country/1');
        $response
            ->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data'=>[
                    'id',
                    'name'
                ]]);
    }
}
