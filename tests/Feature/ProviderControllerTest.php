<?php

namespace Tests\Feature;

use App\Models\Provder;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProviderControllerTest extends TestCase
{
    /** @test */
    public function an_admin_can_store_a_provider()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->postJson(route('providers.store'), $request)
            ->assertSuccessful();

        $provider = Provider::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($provider) {
            $this->assertEquals($value, $provider->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_update_a_provider()
    {
        $admin = factory(User::class)->state('admin')->create();
        $provider = factory(Provider::class)->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->putJson(route('providers.update', $provider), $request)
            ->assertSuccessful();

        $provider = $provider->fresh();

        collect($request)->each(function ($value, $attrib) use ($provider) {
            $this->assertEquals($value, $provider->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_destroy_a_provider()
    {
        $admin = factory(User::class)->state('admin')->create();
        $provider = factory(Provider::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('providers.destroy', $provider))
            ->assertSuccessful();

        $this->assertTrue($provider->fresh()->trashed());
    }

    /** @test */
    public function an_admin_can_view_a_single_provider()
    {
        $admin = factory(User::class)->state('admin')->create();
        $provider = factory(Provider::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('providers.show', $provider))
            ->assertSuccessful()
            ->assertJson(['id' => $provider->id]);
    }

    /** @test */
    public function an_admin_can_view_a_list_the_providers()
    {
        $admin = factory(User::class)->state('admin')->create();
        factory(Provider::class, 3)->create();
        
        $this
            ->actingAs($admin)
            ->getJson(route('providers.index'))
            ->assertSuccessful()
            ->assertJson(['total' => 3]);
    }

    /** @test */
    public function a_guest_cannot_perform_any_action()
    {
        $providers = factory(Provider::class, 3)->create();
        $provider = $providers->first();
        
        $this->getJson(route('providers.index'))->assertStatus(401);
        $this->getJson(route('providers.show', $provider))->assertStatus(401);
        $this->putJson(route('providers.update', $provider))->assertStatus(401);
        $this->deleteJson(route('providers.destroy', $provider))->assertStatus(401);
    }

    /** @test */
    public function the_provider_slug_is_generated_automatically_if_not_set()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        unset($request['slug']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('providers.store'), $request)
            ->assertSuccessful();

        $provider = Provider::find($response->json('id'));

        $this->assertNotNull($provider->slug);
    }

    private function getValidRequestData($override = [])
    {
        return array_filter(factory(Provider::class)->raw($override));
    }
}
