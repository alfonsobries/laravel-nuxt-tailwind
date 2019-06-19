<?php

namespace Tests\Feature;

use App\Models\Column;
use App\Models\Layout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function an_admin_can_store_a_single_data_item()
    {
        $admin = factory(User::class)->state('admin')->create();
        $layout = factory(Layout::class)->create();

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

        $data = collect([
            'your_name' => $this->faker()->name,
            'birthday' => $this->faker()->date,
            'your_time' => '12:30',
            'end_of_the_world' => $this->faker()->dateTime->format('Y-m-d H:i:s'),
            'money_in_your_wallet' => $this->faker()->randomFloat,
            'age' => $this->faker()->randomDigitNotNull,
        ]);

        $response = $this
            ->actingAs($admin)
            ->postJson(route('data.store', ['layout' => $layout]), $data->toArray())
            ->assertSuccessful();

        $dataItem = $layout->getDataTable()->find($response->json('id'));

        $data->each(function ($value, $attribute) use ($dataItem) {
            $this->assertEquals($value, $dataItem->{$attribute});
        });
    }
}
