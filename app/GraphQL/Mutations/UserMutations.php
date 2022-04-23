<?php
namespace App\GraphQL\Mutations;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserMutations
{
    public function editUser($_, array $args){
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(User::find(Auth::id()))->update($args);
    }
}