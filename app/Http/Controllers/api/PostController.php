<?php

namespace App\Http\Controllers\api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DevProject;
use App\Models\Post;

class PostController extends Controller
{
    public function listPost(Request $request){
        $args = $request->all();
        $current = $args['current'];
        $pageSize = $args['pageSize'];

        $start = (($current -1) * $pageSize);
        $post = Post::select('*')->withTrashed();

        if(isset($args['search_key']) && $args['search_key']){
            $search_key = $args['search_key'];
            $post = Post::where('title','like','%'. $search_key .'%' )
                ->orWhere('description','like','%'. $search_key .'%' )
                ->orWhere('content','like','%'. $search_key .'%' )
                ->orderBy('created_at', 'desc');
        }
        
        if(isset($request['sort_field']) && $request['sort_field']!= null){
            if(isset($request['sort_order']) && $request['sort_order'] != null){
                $field = $request['sort_field'];
                $order = $request['sort_order'] == '' ? 'ASC' : $request['sort_order'];
                $post->orderBy($field, $order);
            }
        }else{
            $post->orderBy('created_at', 'desc');
        }

        $request = array_diff_key($request->all(), array_flip(['current', 'pageSize','sort_field','sort_order', 'search_key']));
        foreach($request as $key => $rq){
            if($rq){
                $post->where($key, 'like', '%' . $rq . '%');
            }
        }
        $total  = count($post->get()->toArray());
        $data = $post->offset($start)->limit($pageSize)->get();
        $data->map(function ($dt) {
            $dt->deleted = $dt->deleted_at ? true : false;
        });
        $fit = (object)array(
            "data" => $data,
            "total"  => $total,
            "success" => true,
            "pageSize" => $pageSize,
            "current" => $current
        );
        return ($fit);
    }

    public function serviceList(Request $request){
        $free_support = DevProject::all()->pluck('free_support')->toArray();
        $fee_support = DevProject::all()->pluck('fee_support')->toArray();

        $service_list = [];
        foreach($free_support as $fs){
            if (is_array($fs) || is_object($fs))
            {
                foreach($fs as $f){
                    array_push($service_list, $f);
                }
            }
        }
        foreach($fee_support as $fs){
            if (is_array($fs) || is_object($fs))
            {
                foreach($fs as $f){
                    array_push($service_list, $f);
                }
            }
        }
        $service_list = array_unique($service_list);
        return ($service_list);
    }
}
