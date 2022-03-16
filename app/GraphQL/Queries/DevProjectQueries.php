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
        $args = $args['input'];
        $devProjetcs = DevProject::where('name','like','%'. $args['search_key'] .'%' );
        if($args['category'] != '' && $args['category'] != "Tất cả"){
            $devProjetcs->whereJsonContains('categories', ['name' => $args['category']]);
        }
        if(!$args['sort_field'] == '')
            $devProjetcs->orderBy($args['sort_field'],$args['sort_order']);
        else
            $devProjetcs->orderBy('created_at', 'desc');
        $paginationInfo = (object)array(
            'total' => $devProjetcs->paginate(
                $args['per_page'],
                ['*'],
                'current_page',
                $args['current_page'],
            )->total(),
            'per_page' => $devProjetcs->paginate(
                $args['per_page'],
                ['*'],
                'current_page',
                $args['current_page'],
            )->perPage(),
            'current_page' => $devProjetcs->paginate(
                $args['per_page'],
                ['*'],
                'current_page',
                $args['current_page'],
            )->currentPage(),
            'last_page' => $devProjetcs->paginate(
                $args['per_page'],
                ['*'],
                'current_page',
                $args['current_page'],
            )->lastPage(),
        );
        return ['devProjects' => $devProjetcs->paginate(
            $args['per_page'],
            ['*'],
            'current_page',
            $args['current_page'],
        ),'paginator' => $paginationInfo];
    }

    public function detailDevProject($_, $args){
        return DevProject::find($args['id']);
    }

    public function similarDevProjects($_, $args){
        $devProject = DevProject::find($args['id']);
        $similarDevProjects = DevProject::where('name','like','%');
        $categories = $devProject->categories;
        foreach($categories as $category){
            $similarDevProjects->orWhereJsonContains('categories', ['name' => $category['name']]);
        }
        return $similarDevProjects->inRandomOrder()->limit($args['limit'])->get();
    }
}
