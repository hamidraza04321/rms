<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;
use App\Models\ClassGroup;
use App\Models\Group;

class HasClassGroup implements InvokableRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

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
        $group_exists_in_class = DB::table('class_groups')
            ->where([
                'class_id' => $this->class_id,
                'deleted_at' => NULL
            ])
            ->exists();

        if (is_null($value) && $group_exists_in_class) {
            $fail('The group field is required for this class.');
        } else {
            $group = Group::whereId($value)->exists();

            if ($group) {
                $exists = ClassGroup::where([
                    'class_id' => $this->class_id,
                    'group_id' => $value
                ])->exists();

                if (!$exists) {
                    $fail('The group does not exists in this class.');
                }   
            }
        }
    }
}
