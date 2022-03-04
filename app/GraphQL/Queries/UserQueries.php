<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserQueries
{

    public function detailMe($_, $args)
    {
        $user = Auth::user();
        return $user;
    }

    public function listUser($_, $args)
    {
        $users = User::where('fullname', 'like', "%{$args['fullname']}%")
            ->get();
        return $users;
    }
}
