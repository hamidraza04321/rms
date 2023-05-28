<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\DB;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\HasGroup;
use App\Models\Scopes\HasUserClassGroup;
use App\Models\UserClassGroup;
use Illuminate\Support\Facades\Route;
use App\Models\ClassGroup;
use App\Models\Group;

class GroupRule implements InvokableRule
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
        // Check if groups exists in class when group is null in request
        $group_exists_in_class = ClassGroup::withoutGlobalScopes([
                HasGroup::class,
                HasUserClassGroup::class
            ])
            ->where('class_id', $this->class_id)
            ->exists();

        if (is_null($value)
            && $group_exists_in_class
            && in_array(Route::currentRouteName(), ['student.store', 'student.update'])) {
            return $fail('The group is required for this class.');
        }

        if (!is_null($value)) {
            $group = Group::withoutGlobalScope(ActiveScope::class)->find($value);
                
            // Check if group exists
            if (!$group) {
                return $fail('The selected group id is invalid.');
            }

            // Check the group exists in class
            $class_group = ClassGroup::withoutGlobalScopes([
                    HasGroup::class,
                    HasUserClassGroup::class
                ])
                ->where([
                    'class_id' => $this->class_id,
                    'group_id' => $value
                ])
                ->first(['id']);

            if (!$class_group) {
                return $fail('The selected group does not exists in this class.');
            }

            // Check user has class group permission without super admin
            if (!auth()->user()->hasRole('Super Admin')) {
                $exists = UserClassGroup::where([
                    'class_group_id' => $class_group->id,
                    'user_id' => auth()->id()
                ])->exists();

                if (!$exists) {
                    return $fail('User does not have permission to this class group.');
                }
            }

            // Check group is active
            if (!$group->is_active) {
                return $fail('The selected group is deactive.');
            }
        }
    }
}
