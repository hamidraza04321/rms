<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\HasUserClassSection;
use App\Models\Scopes\HasSection;
use App\Models\ClassSection;
use App\Models\UserClassSection;
use App\Models\Section;

class SectionRule implements InvokableRule
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
        $section = Section::withoutGlobalScope(ActiveScope::class)->find($value);

        // Check if section exists
        if (!$section) {
            return $fail('The selected section id is invalid.');
        }

        // Check the section exists in class
        $class_section = ClassSection::withoutGlobalScopes([
                HasSection::class,
                HasUserClassSection::class
            ])
            ->where([
                'class_id' => $this->class_id,
                'section_id' => $value
            ])->first([
                'id'
            ]);

        if (!$class_section) {
            return $fail('The section does not exists in this class.');
        }

        // Check user has class section permission without super admin
        if (!auth()->user()->hasRole('Super Admin')) {
            $exists = UserClassSection::where([
                'class_section_id' => $class_section->id,
                'user_id' => auth()->id()
            ])->exists();

            if (!$exists) {
                return $fail('User does not have permission to this class section.');
            }
        }

        // Check section is active
        if (!$section->is_active) {
            return $fail('The selected section is deactive.');
        }
    }
}
