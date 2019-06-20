<?php

namespace Tests\Unit;

use App\Models\Column;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColumnRelationshipTest extends TestCase
{
    /** @test */
    public function a_column_can_be_related_with_another_column()
    {
        $foreignColumn = factory(Column::class)->create();
        $referencedColumn = factory(Column::class)->create();

        $foreignColumn->relationships()->sync($referencedColumn);
        
        $this->assertEquals(
            [$referencedColumn->id],
            $foreignColumn->relationships()->pluck('id')->toArray()
        );
    }
}
