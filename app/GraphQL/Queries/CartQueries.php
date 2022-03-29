<?php

namespace App\GraphQL\Queries;

use App\Models\Cart;
use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartQueries
{
    function listCart(){
        $carts = Cart::all();
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
            $item->carts = Cart::where('user_id', Auth::id())
            ->where('created_at', 'like', $item->created_at . '%')
            ->orderBy('created_at','desc')
            ->get();

            return $item;
        });
        return $day;
    }
}