<?php

namespace App\Traits;

use App\Models\Company;

trait BelongsToCompany
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
