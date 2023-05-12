<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\ClassSection;
use App\Models\Section;

class HasClassSection implements InvokableRule
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
        $section = Section::whereId($value)->exists();
        
        if ($section) {
            $exists = ClassSection::where([
                'class_id' => $this->class_id,
                'section_id' => $value
            ])->exists();

            if (!$exists) {
                $fail('The section does not exists in this class.');
            }
        }
    }
}
