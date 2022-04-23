<?php

namespace App\GraphQL\Queries;

use App\Models\CustomerFeeling;
use Illuminate\Support\Facades\Auth;

class FeelingQueries
{
    public function listFeeling($_, array $args)
    {
        $args = $args['input'];
        $current = $args['current_page'];
        $pageSize = $args['per_page'];
        $start = (($current -1) * $pageSize);
        $post = CustomerFeeling::select('*');
        
        if(isset($args['search_key']) && $args['search_key']){
            $search_key = $args['search_key'];
            $post = CustomerFeeling::where('title','like','%'. $search_key .'%' )
                ->orWhere('description','like','%'. $search_key .'%' )
                ->orWhere('content','like','%'. $search_key .'%' )
                ->orderBy('created_at', 'desc');
        }
        
        if(isset($args['sort_field']) && $args['sort_field']!= null){
            if(isset($args['sort_order']) && $args['sort_order'] != null){
                $field = $args['sort_field'];
                $order = $args['sort_order'] == '' ? 'ASC' : $args['sort_order'];
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

    public function listMyFeeling($_, array $args)
    {
        return CustomerFeeling::where('user_id', Auth::id())->get();
    }

    public function detailFeeling($_, array $args)
    {
        $feeling = CustomerFeeling::where('id', $args['id'])->first();
        return $feeling;
    }
}