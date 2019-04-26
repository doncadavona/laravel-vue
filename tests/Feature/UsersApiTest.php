<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

/**
 * Feature test class for the Users API endpoints.
 * This tests whether the app does what is supposed on positive scenarios.
 */
class UsersApiTest extends TestCase
{
    protected static $fake_user;

    public static function setUpBeforeClass()
    {
        // Create a fake user for testing
        $faker = \Faker\Factory::create();

        self::$fake_user = [
            'email'                 => $faker->safeEmail,
            'password'              => 'secret',
            'password_confirmation' => 'secret',

            'username'              => $faker->userName,
            'first_name'            => $faker->firstName,
            'last_name'             => $faker->lastName,
            'address'               => $faker->address,
            'postcode'              => $faker->randomNumber(4),
            'contact_phone_number'  => '09' . $faker->randomNumber(9),
        ];
    }

    /**
     * Note: this test may fail if test data already exists
     * @return void
     */
    public function testStore()
    {
        $response = $this->json('POST', route('api.users.store', $this::$fake_user));

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'username',
                'email',
                'first_name',
                'last_name',
                'address',
                'postcode',
                'contact_phone_number',
            ]);
    }

    public function testShow()
    {
        $fake_user = User::where('email', $this::$fake_user['email'])->first();

        if ($fake_user) {
            $response = $this->json('GET', route('api.users.show', $fake_user->id));

            $response
                ->assertStatus(200)
                ->assertJsonStructure([]);
        } else {
            // There is no user to test
        }
    }

    public function testUpdate()
    {
        $fake_user = User::where('email', $this::$fake_user['email'])->first();

        $response = $this->json('PATCH',
            route('api.users.update', $fake_user->id),
                $fake_user->only([
                    'username',
                    'email',
                    'first_name',
                    'last_name',
                    'address',
                    'postcode',
                    'contact_phone_number'
                ])
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'username',
                'email',
                'first_name',
                'last_name',
                'address',
                'postcode',
                'contact_phone_number',
            ]);
    }

    public function testIndex()
    {
        $response = $this->json('GET', route('api.users.index'));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    'id',
                    'username',
                    'email',
                    'first_name',
                    'last_name',
                    'address',
                    'postcode',
                    'contact_phone_number',
                ],
            ]);
    }

    public function testDelete()
    {
        $fake_user = User::where('email', $this::$fake_user['email'])->first();

        $response = $this->json('DELETE', route('api.users.destroy', $fake_user));

        $response
            ->assertStatus(200);
    }

    public function testDeleteMultiple()
    {
        $fake_users = User::take(3);

        $response = $this->json('DELETE',
                route('api.users.destroy_multiple'), [
                    'ids' => $fake_users->pluck('id')->toArray()
                ]
            );

        $response
            ->assertStatus(200);
    }
}
