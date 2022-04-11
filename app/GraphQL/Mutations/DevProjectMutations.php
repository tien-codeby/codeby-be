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
        if(isset($args['force_approve']) == true)
            $args['approved'] = true; // default approved with approve_f
        $args['user_id'] = Auth::id();
        return DevProject::create($args);
    }

    public function editDevProject($_, array $args): DevProject
    {
        if(isset($args['force_edit']) && $args['force_edit'] ){
            $args = array_diff_key($args, array_flip(['directive']));
            return tap(DevProject::find($args['id']))
            ->update($args);
        }
        $dev = DevProject::find($args['id']);
        if($dev->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(DevProject::find($args['id']))
            ->update($args);
    }
    public function deleteDevProject($_, array $args): bool
    {
        if(isset($args['force_delete']) && $args['force_delete']) 
            return DevProject::destroy($args['id']) > 0 ? true : false;
        $dev = DevProject::find($args['id']);
        if($dev->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
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
