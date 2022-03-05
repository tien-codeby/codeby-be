<?php

namespace App\GraphQL\Queries;

use App\Models\Cart;
use App\Models\DevProject;
use Illuminate\Support\Facades\Auth;

class CartQueries
{
    function listCart(){
        $carts = Cart::all();
        return $carts;
    }
    function listMyCart(){
        $carts = Cart::where('user_id', Auth::id())->get();
        return $carts;
    }
}