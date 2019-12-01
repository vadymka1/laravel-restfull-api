<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    /**
     * @test
     */
    public function test_can_create_user()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
//            '_id' => '5ddd94aa9303fc34912ac293'

        ];

        $response = $this
            ->json('POST', 'api/v1/user/', $data, $this->headers());

        $response
            ->assertStatus(200)
            ->assertJson(['data' => $data])
        ;

    }

    /**
     * @test
     */
    public function test_can_update_user()
    {
        $user = factory(User::class)->create();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            '_method' => 'PUT',
        ];

        $response = $this->json('PUT', 'api/v1/user/'. $user->_id, $data, $this->headers());
        $response->assertStatus(201);
//            ->assertJson(['data' => $user])
        ;
    }

    /**
     * @test
     */
    public function test_can_show_user()
    {
        $user = factory(User::class)->create();

        $response = $this->json('GET', 'api/v1/user/'. $user->_id, $this->headers());
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_can_delete_post()
    {

        $user = factory(User::class)->create();

        $response = $this
            ->json('GET', 'api/v1/user/'. $user->_id, [], $this->headers());
        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function test_can_list_posts()
    {

        $response = $this->json('GET', 'api/v1/user', [], $this->headers());
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]
        );

    }
}
