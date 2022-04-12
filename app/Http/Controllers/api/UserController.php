<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\DevProject;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listUser(Request $request){
        $current = $request->current;
        $pageSize = $request->pageSize;
        $search_key = $request->search_key;

        $start = (($current -1) * $pageSize);
        $user = User::select('*');

        if(isset($search_key)){
            if(is_numeric($search_key)){
                $user = User::where('phone','like','%'. $search_key .'%' );
            }else{
                $user = User::where('fullname','like','%'. $search_key .'%' );
            }
        }else{
            $user = User::select('*');
        }

        if(isset($request['sort_field']) && $request['sort_field']!= null){
            if(isset($request['sort_order']) && $request['sort_order'] != null){
                $field = $request['sort_field'];
                $order = $request['sort_order'] == '' ? 'ASC' : $request['sort_order'];
                $user->orderBy($field, $order);
            }
        }else{
            $user->orderBy('created_at', 'desc');
        }

        $total  = count($user->get()->toArray());
        $user = $user->offset($start)->limit($pageSize)->get();

        $data = $user->map(function($user){
            $count_theme_buyed = 0;
            $theme_buyed = Cart::where('user_id', $user->id)->get();
            foreach ($theme_buyed as $theme){
                foreach ($theme->products as $product){
                    $count_theme_buyed += 1;
                }
            }
            $count_has_project = DevProject::where('user_id', $user->id)->count();
            $user->count_theme_buyed = $count_theme_buyed;
            $user->count_has_project = $count_has_project;
            unset($user->token);
            unset($user->email_verified_at);
            return $user;
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
}