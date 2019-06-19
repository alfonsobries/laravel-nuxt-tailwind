<?php

namespace App\Policies;

use App\Models\Data;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the data.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->is_admin;
    }
    
    /**
     * Determine whether the user can view the data.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Data  $data
     * @return mixed
     */
    public function show(User $user, Data $data)
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
     * Determine whether the user can update the data.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Data  $data
     * @return mixed
     */
    public function update(User $user, Data $data)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can destroy the data.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Data  $data
     * @return mixed
     */
    public function destroy(User $user, Data $data)
    {
        return $user->is_admin;
    }
}
