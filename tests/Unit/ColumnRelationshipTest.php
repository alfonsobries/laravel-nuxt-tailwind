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
        $column = factory(Column::class)->create(['slug' => 'sales_product_upc']);
        $referedColumn = factory(Column::class)->create(['slug' => 'product_upc']);

        $column->reference = $referedColumn;

        $this->assertTrue($column->reference->is($referedColumn));
    }

    /** @test */
    public function when_a_columns_refers_another_columns_it_created_the_foreign_key()
    {
        $referedColumn = factory(Column::class)->create(
            [
                'slug' => 'product_upc',
                'type' => Column::TYPE_INTEGER
            ]
        );
        
        $column = factory(Column::class)->create([
            'slug' => 'sales_product_upc',
            'reference_column_id' => $referedColumn->id,
            'type' => Column::TYPE_INTEGER
        ]);

        $exists = DB::table('information_schema.table_constraints')
                ->selectRaw('*')
                ->where('table_name', $column->table_name)
                ->where('constraint_name', sprintf('%s_%s_key', $column->slug, $referedColumn->slug))
                ->exists();

        $this->assertTrue($exists);
    }
}
