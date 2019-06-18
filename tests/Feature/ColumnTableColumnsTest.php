<?php

namespace Tests\Feature;

use App\Models\Column;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ColumnTableColumnsTest extends TestCase
{
    /** @test */
    public function when_a_column_is_created_it_add_the_columns_to_the_table()
    {
        $typesToCheck = collect([
            Column::TYPE_TEXT => 'string',
            Column::TYPE_DATE => 'date',
            Column::TYPE_DATETIME => 'datetime',
            Column::TYPE_TIME => 'time',
            Column::TYPE_FLOAT => 'float',
            Column::TYPE_INTEGER => 'integer',
        ]);

        $typesToCheck->each(function ($typeToCheck, $columnType) {
            $column = factory(Column::class)->create(['type' => $columnType]);

            $this->assertTrue(Schema::hasColumn($column->table_name, $column->slug));
            
            $this->assertEquals($typeToCheck, Schema::getColumnType($column->table_name, $column->slug));
        });
    }

    /** @test */
    public function when_a_column_is_updated_it_update_the_columns_in_the_table()
    {
        $typesToCheck = collect([
            Column::TYPE_TEXT => 'string',
            Column::TYPE_DATE => 'date',
            Column::TYPE_DATETIME => 'datetime',
            Column::TYPE_TIME => 'time',
            Column::TYPE_FLOAT => 'float',
            Column::TYPE_INTEGER => 'integer',
        ]);

        $typesToCheck->each(function ($typeToCheck, $columnType) use ($typesToCheck) {
            $typesToCheck->each(function ($typeToCheck2, $columnType2) use ($typeToCheck, $columnType) {
                $column = factory(Column::class)->create(['type' => $columnType]);

                $originalSlug = $column->slug;

                $this->assertTrue(Schema::hasColumn($column->table_name, $originalSlug));
                
                $this->assertEquals($typeToCheck, Schema::getColumnType($column->table_name, $originalSlug));

                $newSlug = $originalSlug . '_2';
                $column->update([
                    'type' => $columnType2,
                    'slug' => $newSlug
                ]);
                
                $this->assertFalse(Schema::hasColumn($column->table_name, $originalSlug), "column $originalSlug still exists");
                $this->assertTrue(Schema::hasColumn($column->table_name, $newSlug), "new column $newSlug doesnt exists");
                
                $this->assertEquals($typeToCheck2, Schema::getColumnType($column->table_name, $newSlug), "new column $newSlug type doesnt change from $columnType to $columnType2");
            });
            
        });
    }

    /** @test */
    public function when_a_column_is_deleted_it_remove_the_columns_from_the_table()
    {
        $column = factory(Column::class)->create();

        $this->assertTrue(Schema::hasColumn($column->table_name, $column->slug));

        $column->delete();

        $this->assertTrue(Schema::hasColumn($column->table_name, $column->slug));

        $column->forceDelete();

        $this->assertFalse(Schema::hasColumn($column->table_name, $column->slug));
    }
}
