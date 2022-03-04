<?php

namespace App\GraphQL\Mutations;

use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;

class DevProjectMutations
{
    public function createDevProject($_, array $args): DevProject
    {
        $args['user_id'] = Auth::id();
        return DevProject::create($args);
    }

    public function editDevProject($_, array $args): DevProject
    {
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(DevProject::find($args['id']))
            ->update($args);
    }
}
