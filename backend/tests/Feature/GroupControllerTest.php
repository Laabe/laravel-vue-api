<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    /**
     * Test listing all groups.
     */
    public function testIndex()
    {
        // Create some test groups
        Group::factory()->count(3)->create();

        // Make a GET request to the index endpoint
        $response = $this->get('/api/groups');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct number of groups
        $response->assertJsonCount(3);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                    'users',
                ],
            ],
        ]);
    }

    /**
     * Test storing a new group.
     */
    public function testStore()
    {
        // Generate a fake group data
        $groupData = Group::factory()->make()->toArray();

        // Make a POST request to the store endpoint with the fake group data
        $response = $this->post('/api/groups', $groupData);

        // Assert that the response has a 201 status code
        $response->assertStatus(201);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
            ],
        ]);

        // Assert that the group has been stored in the database
        $this->assertDatabaseHas('groups', $groupData);
    }

    /**
     * Test showing a specific group.
     */
    public function testShow()
    {
        // Create a test group
        $group = Group::factory()->create();

        // Make a GET request to the show endpoint with the group ID
        $response = $this->get('/api/groups/' . $group->id);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
                'users',
            ],
        ]);

        // Assert that the response contains the correct group data
        $response->assertJson([
            'data' => [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                // Add assertions for other attributes if needed
            ],
        ]);
    }

    /**
     * Test updating a specific group.
     */
    public function testUpdate()
    {
        // Create a test group
        $group = Group::factory()->create();

        // Generate a fake updated group data
        $updatedGroupData = Group::factory()->make()->toArray();

        // Make a PUT request to the update endpoint with the updated group data
        $response = $this->put('/api/groups/' . $group->id, $updatedGroupData);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is correct
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
            ],
        ]);

        // Assert that the group has been updated in the database
        $this->assertDatabaseHas('groups', $updatedGroupData);
    }

    /**
     * Test deleting a specific group.
     */
    public function testDestroy()
    {
        // Create a test group
        $group = Group::factory()->create();

        // Make a DELETE request to the destroy endpoint
        $response = $this->delete('/api/groups/' . $group->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the group has been deleted from the database
        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }

    /**
     * Test detaching a user from a group.
     */
    public function testDetach()
    {
        // Create a test group and user
        $group = Group::factory()->create();
        $user = User::factory()->create();

        // Attach the user to the group
        $group->users()->attach($user);

        // Make a DELETE request to the detach endpoint
        $response = $this->post('/api/groups/' . $group->id . '/detach-user/' . $user->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the user is detached from the group
        $this->assertDatabaseMissing('group_user', ['group_id' => $group->id, 'user_id' => $user->id]);
    }

    /**
     * Test attaching a user to a group.
     */
    public function testAttach()
    {
        // Create a test group and user
        $group = Group::factory()->create();
        $user = User::factory()->create();

        // Make a POST request to the attach endpoint
        $response = $this->post('/api/groups/' . $group->id . '/attach-user/' . $user->id);

        // Assert that the response has a 204 status code
        $response->assertStatus(204);

        // Assert that the user is attached to the group
        $this->assertDatabaseHas('group_user', ['group_id' => $group->id, 'user_id' => $user->id]);
    }
}
