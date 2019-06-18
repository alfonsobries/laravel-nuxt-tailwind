<?php

namespace Tests\Feature;

use App\Models\Data;
use App\Models\Layout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LayoutTablesTest extends TestCase
{
    /** @test */
    public function when_creating_a_layout_it_creates_the_data_table()
    {
        $layout = factory(Layout::class)->create();

        $this->assertTrue(Schema::hasTable($layout->table_name));
    }

    /** @test */
    public function when_updating_the_layout_table_name_it_updated_the_table_name()
    {
        $layout = factory(Layout::class)->create();

        $originalTableName = $layout->table_name;
        
        $this->assertTrue(Schema::hasTable($originalTableName));

        $layout->table_name = 'new_table_name';
        $layout->save();

        $this->assertFalse(Schema::hasTable($originalTableName));
        $this->assertTrue(Schema::hasTable($layout->table_name));
    }

    /** @test */
    public function when_deleting_a_layout_it_deletes_the_data_table()
    {
        $layout = factory(Layout::class)->create();

        $this->assertTrue(Schema::hasTable($layout->table_name));

        $layout->delete();

        $this->assertTrue(Schema::hasTable($layout->table_name));        

        $layout->forceDelete();

        $this->assertFalse(Schema::hasTable($layout->table_name));        
    }
}
