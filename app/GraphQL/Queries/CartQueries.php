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
        $carts = Cart::orderBy('created_at','desc')
            ->get();

        $carts->map(function ($item) {
            $user = User::find($item->user_id);
            $item->user_fullname = $user->fullname;
            $item->user_phone = $user->phone;
            $item->products = array_map(function($it) use($item) {
                $project_sell_buy = ProjectSellBuy::where('cart_id',$item->id)
                    ->first();
                $it["status"] = $project_sell_buy->status;
                return $it;
            },$item->products);
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