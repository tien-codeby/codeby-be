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
        $devProjetcs = DevProject::where('name','like','%'. $args['search_key'] .'%' );
        foreach($args['sort'] as $sort){
            if($sort['field'] == 'categories'){ 
                $devProjetcs->whereJsonContains('categories', ['name' => $sort['order']]);
            }
            else{
                $devProjetcs->orderBy($sort['field'],$sort['order']);
            }
        }
        $paginationInfo = (object)array(
            'total' => $devProjetcs->paginate(
                $args['count'],
                ['*'],
                'page',
                $args['page'],
            )->total(),
            'per_page' => $devProjetcs->paginate(
                $args['count'],
                ['*'],
                'page',
                $args['page'],
            )->perPage(),
            'current_page' => $devProjetcs->paginate(
                $args['count'],
                ['*'],
                'page',
                $args['page'],
            )->currentPage(),
            'last_page' => $devProjetcs->paginate(
                $args['count'],
                ['*'],
                'page',
                $args['page'],
            )->lastPage(),
        );
        return ['devProjects' => $devProjetcs->paginate(
            $args['count'],
            ['*'],
            'page',
            $args['page'],
        ),'paginator' => $paginationInfo];
    }

    public function detailDevProject($_, $args){
        return DevProject::find($args['id']);
    }
}
