<?php

namespace Tests\Feature;

use App\Models\Layout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LayoutControllerTest extends TestCase
{
    /** @test */
    public function an_admin_can_store_a_layout()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->postJson(route('layouts.store'), $request)
            ->assertSuccessful();

        $layout = Layout::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($layout) {
            $this->assertEquals($value, $layout->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_update_a_layout()
    {
        $admin = factory(User::class)->state('admin')->create();
        $layout = factory(Layout::class)->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->putJson(route('layouts.update', $layout), $request)
            ->assertSuccessful();

        $layout = $layout->fresh();

        collect($request)->each(function ($value, $attrib) use ($layout) {
            $this->assertEquals($value, $layout->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_destroy_a_layout()
    {
        $admin = factory(User::class)->state('admin')->create();
        $layout = factory(Layout::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('layouts.destroy', $layout))
            ->assertSuccessful();

        $this->assertTrue($layout->fresh()->trashed());
    }

    /** @test */
    public function an_admin_can_view_a_single_layout()
    {
        $admin = factory(User::class)->state('admin')->create();
        $layout = factory(Layout::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('layouts.show', $layout))
            ->assertSuccessful()
            ->assertJson(['id' => $layout->id]);
    }

    /** @test */
    public function an_admin_can_view_a_list_the_layouts()
    {
        $admin = factory(User::class)->state('admin')->create();
        factory(Layout::class, 3)->create();
        
        $this
            ->actingAs($admin)
            ->getJson(route('layouts.index'))
            ->assertSuccessful()
            ->assertJson(['total' => 3]);
    }

    /** @test */
    public function a_guest_cannot_perform_any_action()
    {
        $layouts = factory(Layout::class, 3)->create();
        $layout = $layouts->first();
        
        $this->getJson(route('layouts.index'))->assertStatus(401);
        $this->getJson(route('layouts.show', $layout))->assertStatus(401);
        $this->putJson(route('layouts.update', $layout))->assertStatus(401);
        $this->deleteJson(route('layouts.destroy', $layout))->assertStatus(401);
    }

    /** @test */
    public function the_layout_slug_is_generated_automatically_if_not_set()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        unset($request['slug']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('layouts.store'), $request)
            ->assertSuccessful();

        $layout = Layout::find($response->json('id'));

        $this->assertNotNull($layout->slug);
    }

    private function getValidRequestData($override = [])
    {
        return array_filter(factory(Layout::class)->raw($override));
    }
}
