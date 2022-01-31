<?php

namespace Database\Factories;

use App\Models\EventSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventSessionFactory extends Factory
{

    protected $model = EventSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Session',
            'detail' => $this->faker->text(100),
            'speaker' => $this->faker->name,
            'speaker_designation' => $this->faker->jobTitle,
            'speaker_company' => $this->faker->company,
            'speaker_image' => $this->faker->imageUrl,
            'rating'    => $this->faker->randomElement([3, 4, 5]),
            'time'      => '10:00AM - 10:45AM',
            'audience_can_join' => false
        ];
    }
}
