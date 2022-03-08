<?php

namespace App\GraphQL\Mutations;

use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;
use App\Rules\OwnerCheckDevProject;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Validator;

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
    public function deleteDevProject($_, array $args): bool
    {
        return DevProject::destroy($args['id']) > 0 ? true : false;
    }
    public function upsertDevProject($_, array $args){
        if(isset($args['id'])){
            $check = Validator::make($args,[
                'id' => ['required',new OwnerCheckDevProject],
            ]);
            if(!$check->fails()){
                return $this->editDevProject($_,$args);
            };
            throw new Error($check->errors()->first());
            
        }else{
            return $this->createDevProject($_, $args);
        }
    }
}
