<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Scopes\ActiveScope;
use App\Models\Session;

class SessionRule implements InvokableRule
{
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
        $session = Session::withoutGlobalScope(ActiveScope::class)->find($value);

        if (!$session) {
            return $fail('The selected session id is invalid.');
        }

        if (!$session->is_active) {
            return $fail('The selected session is deactive.');
        }
    }
}
