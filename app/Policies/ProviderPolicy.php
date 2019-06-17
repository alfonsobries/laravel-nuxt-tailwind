<?php

namespace App\Policies;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderPolicy
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
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function show(User $user, Provider $provider)
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
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function update(User $user, Provider $provider)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can destroy the provider.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function destroy(User $user, Provider $provider)
    {
        return $user->is_admin;
    }
}
