<?php

namespace Tests\Unit;

use App\Models\Column;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ColumnRelationshipTest extends TestCase
{
    /** @test */
    public function a_column_can_be_related_with_another_column()
    {
        $column = factory(Column::class)->create(['slug' => 'sales_product_upc', 'type' => Column::TYPE_INTEGER,]);
        $referedColumn = factory(Column::class)->create(['slug' => 'product_upc', 'type' => Column::TYPE_INTEGER,]);

        $column->reference = $referedColumn;

        $this->assertTrue($column->reference->is($referedColumn));
    }

    /** @test */
    public function when_a_columns_refers_another_columns_it_created_the_foreign_key()
    {
        $referedColumn = factory(Column::class)->create([
            'slug' => 'product_upc',
            'type' => Column::TYPE_INTEGER,
        ]);

        $column = factory(Column::class)->create([
            'slug' => 'sales_product_upc',
            'reference_column_id' => $referedColumn->id,
            'type' => Column::TYPE_INTEGER,
        ]);

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertTrue($exists);
    }

    /** @test */
    public function when_a_columns_is_updated_with_a_new_relationship_it_created_the_foreign_keys()
    {
        $referedColumn = factory(Column::class)->create([
            'slug' => 'product_upc',
            'type' => Column::TYPE_INTEGER,
        ]);

        $column = factory(Column::class)->create([
            'slug' => 'sales_product_upc',
            'type' => Column::TYPE_INTEGER,
        ]);

        $column->reference = $referedColumn;

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertTrue($exists);
    }

    /** @test */
    public function when_a_columns_stop_refering_another_columns_it_removes_the_foreign_key()
    {
        $referedColumn = factory(Column::class)->create([
            'slug' => 'product_upc',
            'type' => Column::TYPE_INTEGER,
        ]);

        $column = factory(Column::class)->create([
            'slug' => 'sales_product_upc',
            'reference_column_id' => $referedColumn->id,
            'type' => Column::TYPE_INTEGER,
        ]);

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertTrue($exists);

        $column->reference = null;
        
        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertFalse($exists);
    }

    /** @test */
    public function when_a_columns_referes_another_columns_it_update_the_foreign_key()
    {
        $referedColumn = factory(Column::class)->create([
            'slug' => 'product_upc',
            'type' => Column::TYPE_INTEGER,
        ]);

        $referedColumn2 = factory(Column::class)->create([
            'slug' => 'product_upc_2',
            'type' => Column::TYPE_INTEGER,
        ]);

        $column = factory(Column::class)->create([
            'slug' => 'sales_product_upc',
            'reference_column_id' => $referedColumn->id,
            'type' => Column::TYPE_INTEGER,
        ]);

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertTrue($exists);

        $column->reference = $referedColumn2;
        
        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertFalse($exists);

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn2->slug))
                ->exists();

        $this->assertTrue($exists);
    }
}
