<?php

namespace App\GraphQL\Mutations;

use App\Models\CustomerProject;
use Illuminate\Support\Facades\Auth;

class CustomerProjectMutations
{
    public function createCustomerProject($_, array $args): CustomerProject
    {
        $args['user_id'] = Auth::id();
        return CustomerProject::create($args);
    }

    public function editCustomerProject($_, array $args): CustomerProject
    {
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(CustomerProject::find($args['id']))
            ->update($args);
    }
    public function deleteCustomerProject($_, array $args): bool
    {
        return CustomerProject::destroy($args['id']) > 0 ? true : false;
    }
}
