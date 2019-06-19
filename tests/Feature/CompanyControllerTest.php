<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_store_a_company()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->postJson(route('companies.store'), $request)
            ->assertSuccessful();

        $company = Company::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($company) {
            $this->assertEquals($value, $company->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_update_a_company()
    {
        $admin = factory(User::class)->state('admin')->create();
        $company = factory(Company::class)->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->putJson(route('companies.update', $company), $request)
            ->assertSuccessful();

        $company = $company->fresh();

        collect($request)->each(function ($value, $attrib) use ($company) {
            $this->assertEquals($value, $company->{$attrib});
        });
    }

    /** @test */
    public function an_admin_can_destroy_a_company()
    {
        $admin = factory(User::class)->state('admin')->create();
        $company = factory(Company::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('companies.destroy', $company))
            ->assertSuccessful();

        $this->assertTrue($company->fresh()->trashed());
    }

    /** @test */
    public function an_admin_can_view_a_single_company()
    {
        $admin = factory(User::class)->state('admin')->create();
        $company = factory(Company::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('companies.show', $company))
            ->assertSuccessful()
            ->assertJson(['id' => $company->id]);
    }

    /** @test */
    public function an_admin_can_list_the_companies()
    {
        $admin = factory(User::class)->state('admin')->create();
        factory(Company::class, 3)->create();
        
        $this
            ->actingAs($admin)
            ->getJson(route('companies.index'))
            ->assertSuccessful()
            ->assertJson(['total' => 3]);
    }

    /** @test */
    public function a_guest_cannot_perform_any_action()
    {
        $companies = factory(Company::class, 3)->create();
        $company = $companies->first();
        
        $this->getJson(route('companies.index'))->assertStatus(401);
        $this->getJson(route('companies.show', $company))->assertStatus(401);
        $this->putJson(route('companies.update', $company))->assertStatus(401);
        $this->deleteJson(route('companies.destroy', $company))->assertStatus(401);
    }

    /** @test */
    public function the_company_slug_is_generated_automatically_if_not_set()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = ['name' => 'Grupo vexilo sa de cv'];

        $response = $this
            ->actingAs($admin)
            ->postJson(route('companies.store'), $request)
            ->assertSuccessful();

        $company = Company::find($response->json('id'));

        $this->assertNotNull($company->slug);
    }

    private function getValidRequestData($override = [])
    {
        return array_filter(factory(Company::class)->raw($override));
    }
}
