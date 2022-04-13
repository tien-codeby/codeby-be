<?php

namespace App\GraphQL\Queries;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostQueries
{
    public function listPost($_, array $args){
        $args = $args['input'];
        $current = $args['current_page'];
        $pageSize = $args['per_page'];
        $search_key = $args['search_key'];

        $start = (($current -1) * $pageSize);
        $post = Post::select('*');

        if(isset($search_key)){
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

        
        $total  = count($post->get()->toArray());
        $data = $post->offset($start)->limit($pageSize)->get();
        
        $fit = (object)array(
            "data" => $data,
            "total"  => $total,
            "success" => true,
            "pageSize" => $pageSize,
            "current" => $current
        );
        return ($fit);
    }
    
    public function listMyPost(){
        return Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }
}