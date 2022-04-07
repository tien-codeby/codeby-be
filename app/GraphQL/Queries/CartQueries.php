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
    function listCart(){

        $arr_status = [
            'Chưa tiếp nhận',
            'Đã tiếp nhận',
            'Đang triển khai',
            'Hoàn thành',
        ];

        $carts = Cart::orderBy('created_at','desc')
            ->get();

        
        $carts->map(function ($item) use($arr_status){
            $status_min = 3 ;
            $item->products = array_map(function($it) use($item) {
                $project_sell_buy = ProjectSellBuy::where('cart_id',$item->id)
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
        return $carts;
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