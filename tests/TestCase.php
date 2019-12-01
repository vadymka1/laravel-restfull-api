<?php

namespace Tests;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $faker;

    /**
     *
     */
    public function setUp()
    {

        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * Create user and get token
     * @return string
     */
    protected function authenticate()
    {

        $user = User::create([
            'first_name' => 'test_name',
            'last_name' => 'test_last_name',
            'email' => 'test@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        $token = JWTAuth::fromUser($user);

        return $token;
    }

    /**
     * @return array
     */
    protected function headers()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. $this->authenticate()
        ];
    }
}
