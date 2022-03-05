<?php

namespace App\GraphQL\Queries;

use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;

class DevProjectQueries
{
    public function listDevProject($_, $args)
    {
        $devProjects = DevProject::all();
        return $devProjects;
    }
    public function listMyDevProject(){
        $devProjects = DevProject::where('user_id', Auth::id())->get();
        return $devProjects;
    }
}
