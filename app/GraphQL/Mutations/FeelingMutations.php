<?php

namespace App\GraphQL\Mutations;

use App\Models\CustomerFeeling;
use Illuminate\Support\Facades\Auth;

class FeelingMutations
{
    public function createFeeling($_, array $args){
        $args['user_id'] = Auth::id();
        return CustomerFeeling::create($args);
    }

    public function editFeeling($_, array $args){
        if(isset($args['force_edit']) && $args['force_edit'] ){
            $args = array_diff_key($args, array_flip(['directive']));
            return tap(CustomerFeeling::find($args['id']))
            ->update($args);
        }
        $dev = CustomerFeeling::find($args['id']);
        if($dev->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(CustomerFeeling::find($args['id']))
            ->update($args);
    }

    public function deleteFeeling($_ , array $args){
        if(isset($args['force_delete']) && $args['force_delete']) 
            return CustomerFeeling::destroy($args['id']) > 0 ? true : false;
        $feeling = CustomerFeeling::find($args['id']);
        if($feeling->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        return CustomerFeeling::destroy($args['id']) > 0 ? true : false;
    }
}