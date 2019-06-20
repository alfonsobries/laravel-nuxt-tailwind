<?php

namespace App\Models;

use App\Models\Column;
use App\Pivots\ColumnRelationship;
use App\Traits\BelongsToLayout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Column extends Model
{
    use SoftDeletes,
        HasSlug,
        BelongsToLayout;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_DATE = 'date';
    const TYPE_TIME = 'time';
    const TYPE_DATETIME = 'datetime';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'integer';

    const ACTION_REPLACE = 'replace';
    const ACTION_IGNORE = 'ignore';
    const ACTION_SUM = 'sum';
    
    protected $fillable = [
        'layout_id',
        'name',
        'slug',
        'type',
        'default',
        'when_duplicated',
        'settings',
        'rules',
        'required',
        'published',
    ];

    protected $casts = [
        'required' => 'boolean',
        'settings' => 'array',
        'rules' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(60)
            ->allowDuplicateSlugs()
            ->usingSeparator('_');
    }

    public static function typeOptions()
    {
        return collect([
            self::TYPE_TEXT,
            self::TYPE_TEXTAREA,
            self::TYPE_SELECT,
            self::TYPE_RADIO,
            self::TYPE_CHECKBOX,
            self::TYPE_DATE,
            self::TYPE_TIME,
            self::TYPE_DATETIME,
            self::TYPE_FLOAT,
            self::TYPE_INTEGER,
        ]);
    }

    public static function casteableTypes($type)
    {
        switch ($type) {
            case self::TYPE_DATE:
                return self::typeOptions()
                    ->reject(self::TYPE_TIME)
                    ->reject(self::TYPE_FLOAT)
                    ->reject(self::TYPE_INTEGER);
            case self::TYPE_TIME:
                return self::typeOptions()
                    ->reject(self::TYPE_DATE)
                    ->reject(self::TYPE_DATETIME)
                    ->reject(self::TYPE_FLOAT)
                    ->reject(self::TYPE_INTEGER);
            case self::TYPE_DATETIME:
                return self::typeOptions()
                    ->reject(self::TYPE_TIME)
                    ->reject(self::TYPE_FLOAT)
                    ->reject(self::TYPE_INTEGER);
            case self::TYPE_FLOAT:
            case self::TYPE_INTEGER:
                return self::typeOptions()
                    ->reject(self::TYPE_DATE)
                    ->reject(self::TYPE_DATETIME)
                    ->reject(self::TYPE_TIME);
        }

        return self::typeOptions();
    }

    public static function columnType($type, $sql = false)
    {
        switch ($type) {
            case self::TYPE_DATE:
                return 'date';
            
            case self::TYPE_DATETIME:
                return $sql ? 'timestamp' : 'datetime';

            case self::TYPE_TIME:
                return 'time';

            // case self::TYPE_FLOAT:
            //     return 'float';

            // case self::TYPE_INTEGER:
            //     return 'integer';
        }

        return $sql ? 'varchar' : 'string';
    }

    public function getColumnTypeAttribute()
    {
        return self::columnType($this->type);
    }

    public function getSqlColumnTypeAttribute()
    {
        return self::columnType($this->type, true);
    }

    public static function actionOptions()
    {
        return collect([
            self::ACTION_REPLACE,
            self::ACTION_IGNORE,
            self::ACTION_SUM,
        ]);
    }

    public function setPublishedAttribute($published)
    {
        if ($published) {
            if (!$this->getOriginal('published_at')) {
                $this->attributes['published_at'] = now();
            }
        } else {
            $this->attributes['published_at'] = null;
        }
    }

    public function getPublishedAttribute()
    {
        return boolval($this->published_at);
    }

    public function getTableNameAttribute()
    {
        return $this->layout->table_name;
    }

    public function rules()
    {
        $rules = is_array($this->rules) ? $this->rules : [];

        switch ($this->type) {
            case self::TYPE_DATE:
            case self::TYPE_DATETIME:
                $rules[] = 'date';
                break;

            case self::TYPE_TIME:
                $rules[] = 'string'; // @TODO custom validator
                break;

            case self::TYPE_FLOAT:
                $rules[] = 'numeric';
                break;

            case self::TYPE_INTEGER:
                $rules[] = 'integer';
                break;

            default:
                $rules[] = 'string'; // @TODO custom validator
                break;
        }

        return $rules;
    }

    public function relationships()
    {
        return $this->belongsToMany(Column::class, 'column_relationship', 'foreign_column_id', 'related_column_id')
            ->using(ColumnRelationship::class);
    }

    public function setReferenceAttribute(Column $column = null)
    {
        $this->reference_column_id = $column ? $column->id : null;
        $this->save();
    }

    public function reference()
    {
        return $this->belongsTo(Column::class, 'reference_column_id');
    }
    
}
