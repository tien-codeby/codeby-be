<?php

namespace App\GraphQL\Mutations;
use App\Rules\OwnerCheckCustomerProject;
use App\Models\CustomerProject;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function upsertCustomerProject($_, array $args){
        if(isset($args['id'])){
            $check = Validator::make($args,[
                'id' => ['required',new OwnerCheckCustomerProject],
            ]);
            if(!$check->fails()){
                return $this->editCustomerProject($_,$args);
            };
            throw new Error($check->errors()->first());
        }else{
            return $this->createCustomerProject($_, $args);
        }
    }
}
