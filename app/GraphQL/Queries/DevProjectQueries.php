<?php

namespace App\GraphQL\Queries;

use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;
use DB;
class DevProjectQueries
{
    public function listDevProject($_, $args)
    {
        return DevProject::all();
    }
    public function listMyDevProject(){
        $day = DB::table('dev_projects')
        ->select(DB::raw('DISTINCT cast(created_at as date) created_at'))
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->groupBy('created_at')
        ->get();

        $day->map(function ($item) {
            $item->projects = DevProject::where('user_id', Auth::id())
            ->where('created_at', 'like', $item->created_at . '%')
            ->orderBy('created_at','desc')
            ->get();
        });
        return $day;
        // \DB::table('dev_projects')
        // ->whereRaw('select DISTINCT cast(created_at as date) created_at from `dev_projects` where `user_id` = 3 and `dev_projects`.`deleted_at` is null group by `created_at` ORDER BY `dev_projects`.`created_at` DESC;')->get();
        $devProject = DevProject::where('user_id', Auth::id())
            // ->orderBy('created_at','desc')
            ->groupBy('created_at')
            ->get();

        return $devProject;
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
