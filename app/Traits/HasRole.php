<?php

namespace App\Traits;

trait HasRole
{
    public static function roleOptions()
    {
        return collect([
            self::ROLE_ROOT,
            self::ROLE_ADMIN,
        ]);
    }

    public function getIsRootAttribute()
    {
        return $this->role === self::ROLE_ROOT;
    }

    public function getIsAdminAttribute()
    {
        return in_array($this->role, [
            self::ROLE_ROOT,
            self::ROLE_ADMIN,
        ]);
    }

    public function getAssignableRolesAttribute()
    {
        if ($this->role === self::ROLE_ROOT) {
            return self::roleOptions();
        }

        if ($this->is_admin) {
            return self::roleOptions()->filter(function ($role) {
                return $role !== self::ROLE_ROOT;
            });
        }

        return collect();
    }
}
