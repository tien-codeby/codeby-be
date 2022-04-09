<?php

namespace App\GraphQL\Queries;

use App\Models\Cart;
use App\Models\DevProject;
use App\Models\ProjectSellBuy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartQueries
{
    function listCart($_, $args){
        $args = $args['input'];
        $current = $args['current_page'];
        $pageSize = $args['per_page'];
    
        $start = (($current -1) * $pageSize);

        $arr_status = [
            'Chưa tiếp nhận',
            'Đã tiếp nhận',
            'Đang triển khai',
            'Hoàn thành',
        ];

        if(isset($args['search_key'])){
            if(is_numeric($args['search_key'])){
                $carts = Cart::where('phone','like','%'. $args['search_key'] .'%' )
                    ->withTrashed();
            }else{
                $carts = Cart::where('fullname','like','%'. $args['search_key'] .'%' )
                    ->withTrashed();
            }
        }else{
            $carts = Cart::withTrashed();
        }
        if(!$args['sort_field'] == '')
            $carts->orderBy($args['sort_field'],$args['sort_order']);
        else
            $carts->orderBy('created_at', 'desc');

        $total  = count($carts->get()->toArray());
        $data = $carts->offset($start)->limit($pageSize)->get();

        
        $data->map(function ($item) use($arr_status, $total, $pageSize, $current){
            $status_min = 3 ;
            $item->user_fullname = $item->fullname;
            $item->user_phone = $item->phone;
            $item->deleted = $item->deleted_at ? true : false;
            unset($item->fullname);
            unset($item->phone);
            $item->products = array_map(function($it) use($item) {
                $project_sell_buy = ProjectSellBuy::where('cart_id',$item->id)
                    ->where('project_id',$it['id'])
                    ->first();
                $it["status"] = @$project_sell_buy->status;
                return $it;
            },$item->products);

            // get status general
            foreach($item->products as $product){
                if(array_search($product["status"], $arr_status) < $status_min){
                    $status_min = array_search($product["status"], $arr_status);
                }
            }
            $item->status = $arr_status[$status_min];
            return $item;
        });
        return [
            'data' => $data,
            'total' => $total,
            'pageSize' => $pageSize,
            'current' => $current,
        ];
}
    
    public function listMyCart(){
        $day = DB::table('carts')
        ->select(DB::raw('DISTINCT cast(created_at as date) created_at'))
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->groupBy('created_at')
        ->get();

        $day->map(function ($item) {
            $item->carts = [];
            $carts = Cart::where('user_id', Auth::id())
            ->where('created_at', 'like', $item->created_at . '%')
            ->orderBy('created_at','desc')
            ->get();

            $carts->map(function ($item) {
                $item->products = array_map(function($it){
                    $project_sell_buy = ProjectSellBuy::where('project_id', $it['id'])
                        ->where('user_buy', Auth::id())
                        ->first();
                    $it["status"] = $project_sell_buy->status;
                    return $it;
                },$item->products);
                return $item;
            });
            $item->carts = $carts;
            return $item;
        });
        return $day;
    }
}