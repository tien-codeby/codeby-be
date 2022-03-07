<?php

namespace App\GraphQL\Queries;

use App\Models\CustomerProject;
use Illuminate\Support\Facades\Auth;

class CustomerProjectQueries
{
    public function listCustomerProject($_, $args)
    {
        return CustomerProject::all();
    }
    public function listMyCustomerProject(){
        return CustomerProject::where('user_id', Auth::id())->get();
    }
    public function searchCustomerProjects($_, $args){
        return CustomerProject::where('name','like','%'. $args['search_key'] .'%' )->get();
    }
}
