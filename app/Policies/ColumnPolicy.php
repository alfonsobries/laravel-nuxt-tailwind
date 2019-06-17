<?php

namespace App\Policies;

use App\Models\Column;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColumnPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the columns.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->is_admin;
    }
    
    /**
     * Determine whether the user can view the column.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Column  $column
     * @return mixed
     */
    public function show(User $user, Column $column)
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
     * Determine whether the user can update the column.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Column  $column
     * @return mixed
     */
    public function update(User $user, Column $column)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can destroy the column.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Column  $column
     * @return mixed
     */
    public function destroy(User $user, Column $column)
    {
        return $user->is_admin;
    }
}
