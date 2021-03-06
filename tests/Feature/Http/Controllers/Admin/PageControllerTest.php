<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Language\Language;
use App\Models\Navigation\Page;
use App\Models\Navigation\SubPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\PageController
 */
class PageControllerTest extends TestCase
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
    public function destroy_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $type = 'page';
        $page = Helpers::createPage();
        $response = $this->actingAs($user)->delete(route('page.destroy', ['page' => $page->id, 'type' => $type]));

        $response->assertRedirect(url(''));
        foreach (Language::all() as $language) {
            $this->assertDeleted('nav_pages', [
                'id' => $page->id,
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
        $type = 'page';
        $page = Helpers::createPage();
        $response = $this->actingAs($user)->get(route('page.edit', ['page' => $page->id, 'type' => $type]));

        $response->assertOk();
        $response->assertViewIs('admin.pages.edit');
        $response->assertViewHas('page');
        $response->assertViewHas('type');
        $response->assertSee($page->text->title);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function navigation_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('page.navigation'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.index');
        $response->assertViewHas('pages');
        $response->assertViewHas('type');
        foreach (Page::where('dropdown', false)->whereNull('special_code')->get() as $page) {
            $response->assertSee($page->name);
        }

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function public_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $type = 'page';
        $page = Helpers::createPage();
        $public = $page->public;
        $response = $this->actingAs($user)->get(route('page.public', ['page' => $page->id, 'type' => $type]));

        $response->assertRedirect(url(''));
        foreach (Language::all() as $language) {
            $this->assertDatabaseHas('nav_pages', [
                'id' => $page->id,
                'language_id' => $language->id,
                'public' => !$public,
            ]);
        }
        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function standalone_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('page.standalone'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.index');
        $response->assertViewHas('pages');
        $response->assertViewHas('type');
        foreach (Page::whereNotNull('special_code')->where('dropdown', false)->get() as $page) {
            $response->assertSee($page->name);
        }

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function subnavigation_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();

        $response = $this->actingAs($user)->get(route('page.subnavigation'));

        $response->assertOk();
        $response->assertViewIs('admin.pages.index');
        $response->assertViewHas('pages');
        $response->assertViewHas('type');
        foreach (SubPage::all() as $page) {
            $response->assertSee($page->name);
        }

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
//        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\Users\User::class)->create();
        $type = 'page';
        $page = Helpers::createPage();
        $data = [];
        foreach (Language::all() as $language) {
            $data['name-' . $language->id] = $this->faker->name;
            $data['content-' . $language->id] = $this->faker->text . $this->faker->text;
        }
        $response = $this->actingAs($user)->put(route('page.update', ['page' => $page->id, 'type' => $type]), $data);

        $response->assertRedirect(route('page.navigation'));
        foreach (Language::all() as $language) {
            $this->assertDatabaseHas('nav_pages', [
//                'name' => $data['name-' . $language->id], TODO add it to match title
                'id' => $page->id,
                'language_id' => $language->id,
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
            \App\Http\Controllers\Admin\PageController::class,
            'update',
            \App\Http\Requests\Pages\UpdateRequest::class
        );
    }

    // test cases...
}
