<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Language\Language;
use App\Models\Navigation\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\NavigationController
 */
class NavigationControllerTest extends TestCase
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

        $response = $this->actingAs($user)->get(route('navigation.create'));

        $response->assertOk();
        $response->assertViewIs('admin.navigation.create');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $navigation = Helpers::createPage();
        $response = $this->actingAs($user)->delete(route('navigation.destroy', ['navigation' => $navigation->id]));

        $response->assertRedirect(route('navigation.index'));
        foreach (Language::all() as $language) {
            $this->assertDeleted('nav_pages', [
                'id' => $navigation->id,
                'language_id' => $language->id,
            ]);
        }

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $navigation = Helpers::createPage();
        $response = $this->actingAs($user)->get(route('navigation.edit', ['navigation' => $navigation->id]));

        $response->assertOk();
        $response->assertViewIs('admin.navigation.edit');
        $response->assertViewHas('navigation');
        $response->assertSee($navigation->name);


        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('navigation.index'));

        $response->assertOk();
        $response->assertViewIs('admin.navigation.index');
        $response->assertViewHas('navigations');

        foreach (Page::where('url', '!=', 'home')->get() as $page) {
            $response->assertSee($page->name);
        }
        $response->assertDontSee('domov');
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function public_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $navigation = Helpers::createPage();
        $public = $navigation->public;

        $response = $this->actingAs($user)->get(route('navigation.public', ['navigation' => $navigation->id]));

        $response->assertRedirect(route('navigation.index'));
        foreach (Language::all() as $language) {
            $this->assertDatabaseHas('nav_pages', [
                'id' => $navigation->id,
                'language_id' => $language->id,
                'public' => !$public,
            ]);
        }
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function reorder_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->post(route('navigation.reorder'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $data = [
            'url' => $this->faker->word . $this->faker->word,
            'public' => $this->faker->boolean,
        ];
        foreach (Language::all() as $language) {
            $data['name-' . $language->id] = $this->faker->name;
            $data['content-' . $language->id] = $this->faker->text . $this->faker->text;
        }
        $response = $this->actingAs($user)->post(route('navigation.store'), $data);

        $response->assertRedirect(route('navigation.index'));
        foreach (Language::all() as $language) {
            $this->assertDatabaseHas('nav_pages', [
                'url' => $data['url'],
//                'name' => $data['name-' . $language->id],
                'language_id' => $language->id,
                'public' => $data['public'],
            ]);
            $this->assertDatabaseHas('nav_pages_texts', [
                'language_id' => $language->id,
                'title' => $data['name-' . $language->id],
                'content' => $data['content-' . $language->id],
            ]);
        }
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\NavigationController::class,
            'store',
            \App\Http\Requests\Navigation\Page\StoreRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $navigation = Helpers::createPage();
        $data = ['public' => $this->faker->boolean];
        foreach (Language::all() as $language) {
            $data['name-' . $language->id] = $this->faker->name;
            $data['content-' . $language->id] = $this->faker->text . $this->faker->text;
        }
        $response = $this->actingAs($user)->put(route('navigation.update', ['navigation' => $navigation->id]), $data);

        $response->assertRedirect(route('navigation.index'));
        foreach (Language::all() as $language) {
            $this->assertDatabaseHas('nav_pages', [
//                'name' => $data['name-' . $language->id], TODO add it to match title
                'id' => $navigation->id,
                'language_id' => $language->id,
                'public' => $data['public'],
            ]);
            $this->assertDatabaseHas('nav_pages_texts', [
                'language_id' => $language->id,
                'title' => $data['name-' . $language->id],
                'content' => $data['content-' . $language->id],
            ]);
        }
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\NavigationController::class,
            'update',
            \App\Http\Requests\Navigation\Page\UpdateRequest::class
        );
    }

    // test cases...
}
