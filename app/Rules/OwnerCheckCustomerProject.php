<?php

namespace App\Rules;

use App\Models\CustomerProject;
use Illuminate\Contracts\Validation\Rule;

class OwnerCheckCustomerProject implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cusProject = CustomerProject::where('id', $value)
            ->first();
        return $cusProject && \auth()->id() == $cusProject->user_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Permission denied.';
    }
}
