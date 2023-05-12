<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\UserClassGroup;
use App\Models\ClassGroup;

class HasUserClassGroup implements InvokableRule
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
            // Get class group id
            $class_group_id = ClassGroup::where([
                'class_id' => $this->class_id,
                'group_id' => $value
            ])->value('id');

            if ($class_group_id) {
                // Check user has class group
                $exists = UserClassGroup::where([
                    'class_group_id' => $class_group_id,
                    'user_id' => auth()->id()
                ])->exists();

                if (!$exists) {
                    $fail('User does not have permission to this group.');
                }
            }
        }
    }
}
