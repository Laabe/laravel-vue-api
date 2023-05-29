<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Test listing all users.
     */
    public function testIndex()
    {
        // Create some test users
        User::factory()->count(3)->create();

        // Make a GET request to the index endpoint
        $response = $this->get('/api/users');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of users
        $response->assertJsonCount(3);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'created_at',
                    'updated_at',
                    'groups',
                ],
            ],
        ]);
    }

    /**
     * Test storing a new user.
     */
    public function testStore()
    {
        // Generate a fake user data
        $userData = User::factory()->make()->toArray();

        // Make a POST request to the store endpoint with the fake user data
        $response = $this->post('/api/users', $userData);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'created_at',
                'updated_at',
            ],
        ]);

        // Assert that the user has been stored in the database
        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * Test showing a specific user.
     */
    public function testShow()
    {
        // Create a test user
        $user = User::factory()->create();

        // Make a GET request to the show endpoint with the user ID
        $response = $this->get('/api/users/' . $user->id);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'created_at',
                'updated_at',
                'groups',
            ],
        ]);

        // Assert that the response contains the correct user data
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Test updating a specific user.
     */
    public function testUpdate()
    {
        // Create a test user
        $user = User::factory()->create();

        // Generate a fake updated user data
        $updatedUserData = User::factory()->make()->toArray();

        // Make a PUT request to the update endpoint with the updated user data
        $response = $this->put('/api/users/' . $user->id, $updatedUserData);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'created_at',
                'updated_at',
            ],
        ]);

        // Assert that the user has been updated in the database
        $this->assertDatabaseHas('users', $updatedUserData);
    }

    /**
     * Test deleting a specific user.
     */
    public function testDestroy()
    {
        // Create a test user
        $user = User::factory()->create();

        // Make a DELETE request to the destroy endpoint
        $response = $this->delete('/api/users/' . $user->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the user has been deleted from the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * Test detaching a group from a user.
     */
    public function testDetach()
    {
        // Create a test user and group
        $user = User::factory()->create();
        $group = Group::factory()->create();

        // Attach the group to the user
        $user->groups()->attach($group);

        // Make a POST request to the detach endpoint
        $response = $this->post('/api/users/' . $user->id . '/detach-group/' . $group->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the group is detached from the user
        $this->assertDatabaseMissing('group_user', ['user_id' => $user->id, 'group_id' => $group->id]);
    }

    /**
     * Test attaching a group to a user.
     */
    public function testAttach()
    {
        // Create a test user and group
        $user = User::factory()->create();
        $group = Group::factory()->create();

        // Make a POST request to the attach endpoint
        $response = $this->post('/api/users/' . $user->id . '/attach-group/' . $group->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the group is attached to the user
        $this->assertDatabaseHas('group_user', ['user_id' => $user->id, 'group_id' => $group->id]);
    }
}
