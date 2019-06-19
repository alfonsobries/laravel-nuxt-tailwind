<?php

namespace Tests\Feature;

use App\Models\Column;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    /** @test */
    public function an_admin_can_store_a_column()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        $response = $this
            ->actingAs($admin)
            ->postJson(route('columns.store'), $request)
            ->assertSuccessful();

        $column = Column::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($column) {
            $this->assertEquals($value, $column->{$attrib}, $attrib . ' is not equal');
        });
    }

    /** @test */
    public function an_admin_can_update_a_column()
    {
        $admin = factory(User::class)->state('admin')->create();
        $column = factory(Column::class)->create();

        $request = $this->getValidRequestData(['layout_id' => null]);

        $response = $this
            ->actingAs($admin)
            ->putJson(route('columns.update', $column), $request)
            ->assertSuccessful();

        $column = $column->fresh();

        collect($request)->each(function ($value, $attrib) use ($column) {
            $this->assertEquals($value, $column->{$attrib}, $attrib . ' is not equal');
        });
    }

    /** @test */
    public function an_admin_can_destroy_a_column()
    {
        $admin = factory(User::class)->state('admin')->create();
        $column = factory(Column::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('columns.destroy', $column))
            ->assertSuccessful();

        $this->assertTrue($column->fresh()->trashed());
    }

    /** @test */
    public function an_admin_can_view_a_single_column()
    {
        $admin = factory(User::class)->state('admin')->create();
        $column = factory(Column::class)->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('columns.show', $column))
            ->assertSuccessful()
            ->assertJson(['id' => $column->id]);
    }

    /** @test */
    public function a_guest_cannot_perform_any_action()
    {
        $columns = factory(Column::class, 3)->create();
        $column = $columns->first();
        
        $this->getJson(route('columns.index'))->assertStatus(401);
        $this->getJson(route('columns.show', $column))->assertStatus(401);
        $this->putJson(route('columns.update', $column))->assertStatus(401);
        $this->deleteJson(route('columns.destroy', $column))->assertStatus(401);
    }

    /** @test */
    public function the_column_slug_is_generated_automatically_if_not_set()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData();

        unset($request['slug']);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('columns.store'), $request)
            ->assertSuccessful();

        $column = Column::find($response->json('id'));

        $this->assertNotNull($column->slug);
    }

    private function getValidRequestData($override = [])
    {
        $data = array_filter(factory(Column::class)->raw($override));

        $data['published'] = isset($data['published_at']) ? boolval($data['published_at']) : false;
        unset($data['published_at']);
        
        return $data;
    }
}
