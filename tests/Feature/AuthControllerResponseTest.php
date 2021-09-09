<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerResponseTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test case give login url with correct credentials when login then return OK status
     *
     * @return void
     */
    public function test_givenLoginUrlWithCorrectCredentialsWhenLoginThenReturnOkStatus()
    {
        $response = $this->postJson('/api/auth/login', ['email' => 'user@user.com', 'password' => 'user']);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function test_givenLoginUrlWithNotCorrectCredentialsWhenLoginThenReturnUnauthorizedStatus()
    {
        $response = $this->postJson('/api/auth/login', ['email' => 'user@user', 'password' => 'user']);
        $response
            ->assertStatus(401)
            ->assertJson([
                'status' => "failure",
            ]);
    }


    public function test_givenRegisterUrlWithCorrectCredentialsWhenRegisterThenReturnCreatedStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => $faker->email(), 'password' => $faker->password()]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => "success",
            ]);
    }


    public function test_givenRegisterUrlWithNoNameWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> '','email' => $faker->email(), 'password' => $faker->password()]);
        $response->assertStatus(400)
            ->assertJson([
            'status'=>'failure',
            'message'=>'Invalid data',
            'data'=>[
                'name'=>[
                        'The name field is required.'
                ]
            ]
        ]);
    }

    public function test_givenRegisterUrlWithNoCorrectNameWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> '1','email' => $faker->email(), 'password' => $faker->password()]);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'name'=>[
                        'The name must be between 2 and 100 characters.'
                    ]
                ]
            ]);
    }

    public function test_givenRegisterUrlWithNoEmailWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => '', 'password' => $faker->password()]);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'email'=>[
                        'The email field is required.'
                    ]
                ]
            ]);
    }

    public function test_givenRegisterUrlWithNoCorrectEmailWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => 'email@', 'password' => $faker->password()]);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'email'=>[
                        'The email must be a valid email address.'
                    ]
                ]
            ]);
    }

    public function test_givenRegisterUrlWithTakenEmailWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => 'user@user.com', 'password' => $faker->password()]);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'email'=>[
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }

    public function test_givenRegisterUrlWithNoPasswordWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => $faker->email(), 'password' => '']);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'password'=>[
                        'The password field is required.'
                    ]
                ]
            ]);
    }

    public function test_givenRegisterUrlWithNoCorrectPasswordWhenRegisterThenReturnBadRequestStatus()
    {
        $faker = Faker::create('App\Models\User');
        $response = $this->postJson('/api/auth/register', ['name'=> $faker->name(),'email' => $faker->email(), 'password' => '1']);
        $response->assertStatus(400)
            ->assertJson([
                'status'=>'failure',
                'message'=>'Invalid data',
                'data'=>[
                    'password'=>[
                        'The password must be at least 6 characters.'
                    ]
                ]
            ]);
    }
}
