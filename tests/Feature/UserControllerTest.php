<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /** @test */
    public function an_admin_can_store_an_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData(['role' => User::ROLE_ADMIN]);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('users.store'), $request)
            ->assertSuccessful();

        $newUser = User::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($newUser) {
            if ($attrib === 'password') {
                $this->assertTrue(Hash::check($value, $newUser->{$attrib}));
            } else {
                $this->assertEquals($value, $newUser->{$attrib});
            }
        });
    }

    /** @test */
    public function an_admin_cannot_store_an_user_with_a_role_of_root()
    {
        $admin = factory(User::class)->state('admin')->create();
        
        $request = $this->getValidRequestData(['role' => User::ROLE_ROOT]);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('users.store'), $request)
            ->assertJsonValidationErrors('role');
    }

    /** @test */
    public function a_root_can_store_an_user_with_a_role_of_root()
    {
        $rootUser = factory(User::class)->state('root')->create();
        
        $request = $this->getValidRequestData(['role' => User::ROLE_ROOT]);

        $response = $this
            ->actingAs($rootUser)
            ->postJson(route('users.store'), $request)
            ->assertSuccessful();

        $newUser = User::find($response->json('id'));

        collect($request)->each(function ($value, $attrib) use ($newUser) {
            if ($attrib === 'password') {
                $this->assertTrue(Hash::check($value, $newUser->{$attrib}));
            } else {
                $this->assertEquals($value, $newUser->{$attrib});
            }
        });
    }

    /** @test */
    public function an_admin_can_update_an_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        $userToEdit = factory(User::class)->state('admin')->create();
        $request = $this->getValidRequestData(['role' => User::ROLE_ADMIN]);

        $response = $this
            ->actingAs($admin)
            ->putJson(route('users.update', $userToEdit), $request)
            ->assertSuccessful();

        $userToEdit = $userToEdit->fresh();
        collect($request)->each(function ($value, $attrib) use ($userToEdit) {
            if ($attrib === 'password') {
                $this->assertTrue(Hash::check($value, $userToEdit->{$attrib}));
            } else {
                $this->assertEquals($value, $userToEdit->{$attrib});
            }
        });
    }

    /** @test */
    public function an_admin_cannot_update_a_root_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        $userToEdit = factory(User::class)->state('root')->create();
        $request = $this->getValidRequestData(['role' => User::ROLE_ADMIN]);

        $response = $this
            ->actingAs($admin)
            ->putJson(route('users.update', $userToEdit), $request)
            ->assertForbidden();
    }

    /** @test */
    public function an_admin_can_delete_an_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        $userToDelete = factory(User::class)->state('admin')->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('users.destroy', $userToDelete))
            ->assertSuccessful();

        $this->assertTrue($userToDelete->fresh()->trashed());
    }

    /** @test */
    public function an_admin_cannot_delete_a_root_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        $userToDelete = factory(User::class)->state('root')->create();
        
        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('users.destroy', $userToDelete))
            ->assertForbidden();
    }

    /** @test */
    public function an_admin_can_view_a_single_user()
    {
        $admin = factory(User::class)->state('admin')->create();
        $userToShow = factory(User::class)->state('root')->create();
        
        $response = $this
            ->actingAs($admin)
            ->getJson(route('users.show', $userToShow))
            ->assertJson(['id' => $userToShow->id]);
    }

    /** @test */
    public function an_admin_can_list_the_users()
    {
        $admin = factory(User::class)->state('admin')->create();
        factory(User::class, 9)->create();
        
        $response = $this
            ->actingAs($admin)
            ->getJson(route('users.index'))
            ->assertJson(['total' => 10]);
    }

    /** @test */
    public function a_guest_cannot_view_an_user()
    {
        $userToShow = factory(User::class)->state('root')->create();
        
        $response = $this
            ->getJson(route('users.show', $userToShow))
            ->assertStatus(401);
    }

    /** @test */
    public function a_guest_cannot_list_the_users()
    {
        $userToShow = factory(User::class)->state('root')->create();
        
        $response = $this
            ->getJson(route('users.index', $userToShow))
            ->assertStatus(401);
    }

    private function getValidRequestData($override = [])
    {
        return array_filter(factory(User::class)->state('store')->raw($override));
    }
}
