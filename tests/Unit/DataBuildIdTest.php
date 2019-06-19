<?php

namespace Tests\Unit;

use App\Models\Column;
use App\Models\Layout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DataBuildIdTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function the_data_items_makes_an_id_with_the_layout_keys()
    {
        $layout = factory(Layout::class)->create();
        $this->makeColumns($layout);

        $columnKeys = $layout->columns()->whereIn('slug', ['your_name', 'age', 'birthday'])->get();
        $layout->columnKeys()->sync($columnKeys);

        $data = collect([
            'your_name' => 'Alfonso Bribiesca',
            'birthday' => '1987-02-18',
            'your_time' => '12:30:00',
            'end_of_the_world' => $this->faker()->dateTime->format('Y-m-d H:i:s'),
            'money_in_your_wallet' => $this->faker()->randomFloat,
            'age' => 8,
        ]);

        $dataItem = $layout->data()->create($data->toArray());

        $this->assertEquals('alfonso-bribiesca_1987-02-18_8', $dataItem->id);
    }

    private function makeColumns($layout)
    {
        $columns = collect([
            [
                'name' => 'Your name',
                'slug' => 'your_name',
                'type' => Column::TYPE_TEXT
            ],
            [
                'name' => 'Birthday',
                'slug' => 'birthday',
                'type' => Column::TYPE_DATE
            ],
            [
                'name' => 'End of the world',
                'slug' => 'end_of_the_world',
                'type' => Column::TYPE_DATETIME
            ],
            [
                'name' => 'Your time',
                'slug' => 'your_time',
                'type' => Column::TYPE_TIME
            ],
            [
                'name' => 'Money in your wallet',
                'slug' => 'money_in_your_wallet',
                'type' => Column::TYPE_FLOAT
            ],
            [
                'name' => 'Age',
                'slug' => 'age',
                'type' => Column::TYPE_INTEGER
            ],
        ]);

        $columns->each(function ($column) use ($layout) {
            $layout->columns()->create($column);
        });
    }
}
