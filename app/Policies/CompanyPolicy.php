<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the companies.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->is_admin;
    }
    
    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return mixed
     */
    public function show(User $user, Company $company)
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
     * Determine whether the user can update the company.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can destroy the company.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Company  $company
     * @return mixed
     */
    public function destroy(User $user, Company $company)
    {
        return $user->is_admin;
    }
}
