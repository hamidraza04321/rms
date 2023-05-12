<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\UserClassSection;
use App\Models\ClassSection;

class HasUserClassSection implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($class_id)
    {
        $this->class_id = $class_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            // Get class section id
            $class_section_id = ClassSection::where([
                'class_id' => $this->class_id,
                'section_id' => $value
            ])->value('id');

            if ($class_section_id) {
                // Check user has class section
                $exists = UserClassSection::where([
                    'class_section_id' => $class_section_id,
                    'user_id' => auth()->id()
                ])->exists();

                if (!$exists) {
                    $fail('User does not have permission to this section.');
                }
            }
        }
    }
}
