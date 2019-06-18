<?php

namespace App\Models;

use App\Traits\BelongsToProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Layout extends Model
{
    use SoftDeletes,
        HasSlug,
        BelongsToProvider;

    protected $fillable = [
        'provider_id',
        'name',
        'slug',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(10)
            ->doNotGenerateSlugsOnUpdate()
            ->usingSeparator('_');
    }

    public function getCompanyAttribute()
    {
        return optional($this->provider)->company;
    }

    public function generateUniqueTableName()
    {
        $provider = $this->provider;   
        $company = $this->company;

        $counter = 0;
        do {
            $tableName = sprintf(
                'data_%s_%s_%s',
                $company->slug,
                $provider->slug,
                $this->slug
            );
            
            $tableName = Str::limit($tableName, 58, null);

            if ($counter > 0) {
                $tableName .= '_' . $counter;

            }

            $counter++;
        } while ($this->where('table_name', $tableName)->exists());
        
        return $tableName;
    }
}
