<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $class_id = $this->faker->numberBetween(1, 10);
        $group_id = (in_array($class_id, [9,10])) ? $this->faker->numberBetween(1, 4) : null;

        return [
            'admission_no' => $this->faker->unique()->numberBetween(1000, 9999),
            'roll_no' => $this->faker->numberBetween(1000, 9999),
            'class_id' => $class_id,
            'section_id' => $this->faker->numberBetween(1, 6),
            'group_id' => $group_id,
            'first_name' => $this->faker->name('null|male|female'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'dob' => $this->faker->date('Y-m-d'),
            'religion' => $this->faker->word,
            'caste' => $this->faker->word,
            'mobile_no' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'admission_date' => $this->faker->date('Y-m-d'),

            // Father Details
            'father_name' => $this->faker->name('male'),
            'father_email' => $this->faker->email,
            'father_phone' => $this->faker->phoneNumber,
            'father_occupation' => $this->faker->jobTitle,

            // Mother Details
            'mother_name' => $this->faker->name('female'),
            'mother_email' => $this->faker->email,
            'mother_phone' => $this->faker->phoneNumber,
            'mother_occupation' => $this->faker->jobTitle,

            // Guardian Details
            'guardian_is' => $this->faker->randomElement(['father', 'mother', 'other']),
            'guardian_name' => $this->faker->name(),
            'guardian_email' => $this->faker->email,
            'guardian_phone' => $this->faker->phoneNumber,
            'guardian_occupation' => $this->faker->jobTitle,

            // Address
            'current_address' => $this->faker->address,
            'permenant_address' => $this->faker->address
        ];
    }
}
