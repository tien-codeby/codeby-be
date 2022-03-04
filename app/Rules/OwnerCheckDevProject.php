<?php

namespace App\Rules;

use App\Models\DevProject;
use Illuminate\Contracts\Validation\Rule;

class OwnerCheckDevProject implements Rule
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
        $devProject = DevProject::where('id', $value)
            ->first();
        return $devProject && \auth()->id() == $devProject->user_id;
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
