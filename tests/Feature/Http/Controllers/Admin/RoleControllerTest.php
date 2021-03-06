<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Roles\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\RoleController
 */
class RoleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('role.create'));

        $response->assertOk();
        $response->assertViewIs('admin.roles.create');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $role = factory(Role::class)->create();
        $response = $this->actingAs($user)->delete(route('role.destroy', ['role' => $role]));

        $response->assertRedirect(route('role.index'));
        $this->assertDeleted($role);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $role = factory(Role::class)->create();

        $response = $this->actingAs($user)->get(route('role.edit', ['role' => $role]));

        $response->assertOk();
        $response->assertViewIs('admin.roles.edit');
        $response->assertViewHas('role');
        $response->assertSee($role->name);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('role.index'));

        $response->assertOk();
        $response->assertViewIs('admin.roles.index');
        $response->assertViewHas('roles');
        foreach (Role::all() as $role) {
            $response->assertSee($role->name);
        }

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
        $response = $this->actingAs($user)->post(route('role.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('role.index'));
        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\RoleController::class,
            'store',
            \App\Http\Requests\Roles\StoreRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $role = factory(Role::class)->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->actingAs($user)->put(route('role.update', ['role' => $role]), $data);

        $response->assertRedirect(route('role.index'));
        $role->refresh();
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($data['name'], $role->name);
        $this->assertEquals($data['description'], $role->description);
        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\RoleController::class,
            'update',
            \App\Http\Requests\Roles\UpdateRequest::class
        );
    }

    // test cases...
}
