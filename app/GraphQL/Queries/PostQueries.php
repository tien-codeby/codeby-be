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
        $start = (($current -1) * $pageSize);
        $post = Post::select('*')->with('user');
        
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

        
        $total  = count($post->get()->toArray());
        $data = $post->offset($start)->limit($pageSize)->get();
        $total_count = ($total - ($pageSize * $current ));
        $paginator = [
            "total"  => $total,
            "per_page" => $pageSize,
            "current_page" => $current,
            "last_page" => $total%$pageSize > 0 ? floor($total/$pageSize)+1 : floor($total/$pageSize),
            "total_count" => $total_count >= 0 ? $total_count : 0,
        ];

        $fit = (object)array(
            "data" => $data,
            "paginator" => $paginator
            
        );
        return $fit;
    }
    
    public function listMyPost(){
        return Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function favoritePost($_, array $args){
        $args = $args['input'];
        return Post::where('created_at', 'like', '%'. $args['month'] . '%' )
            ->limit($args['limit'])
            ->orderBy('views', 'desc')
            ->get();
    }

    public function detailPost($_, array $args){
        $post = Post::find($args['id']);
        $post->views += 1  ;
        $post->save();
        return $post;
    }

}