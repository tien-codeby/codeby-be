<?php

namespace App\GraphQL\Queries;

use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;

class DevProjectQueries
{
    public function listDevProject($_, $args)
    {
        return DevProject::all();
    }
    public function listMyDevProject(){
        return DevProject::where('user_id', Auth::id())->get();
    }
    public function searchDevProjects($_, $args){
        return DevProject::where('name','like','%'. $args['search_key'] .'%' )->get();
    }
}
