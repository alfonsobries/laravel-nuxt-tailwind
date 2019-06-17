<?php

namespace App\Policies;

use App\Models\Layout;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the providers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->is_admin;
    }
    
    /**
     * Determine whether the user can view the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function show(User $user, Layout $layout)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can store models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function update(User $user, Layout $layout)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can destroy the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function destroy(User $user, Layout $layout)
    {
        return $user->is_admin;
    }
}
