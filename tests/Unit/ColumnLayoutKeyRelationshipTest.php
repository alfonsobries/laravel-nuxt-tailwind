<?php

namespace Tests\Unit;

use App\Models\Column;
use App\Models\Layout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColumnLayoutKeyRelationshipTest extends TestCase
{
    /** @test */
    public function a_layout_can_had_multiple_columns_as_key()
    {
        $layout = factory(Layout::class)->create();
        $columns = factory(Column::class, 3)->create(['layout_id' => $layout->id]);

        $layout->columnKeys()->sync($columns);
        
        $this->assertEquals(
            $layout->columnKeys()->get()->pluck('id')->toArray(),
            $columns->pluck('id')->toArray()
        );
    }
}
