<?php

namespace App\GraphQL\Mutations;

use App\Jobs\SendEmail;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartMutations
{
    function createCart($_, array $args){
        $message = [
            'type' => 'Tạo một giỏ hàng',
            'task' => 'Kiểm tra',
            'content' => 'Bạn đã tạo một giỏ hàng thành công',
        ];
        SendEmail::dispatch($message, [Auth::user()]);
        $args['user_id'] = Auth::id();
        return Cart::create($args);
    }
    function editCart($_, array $args){
        if(!isset($args['id'])) throw(new Exception('missing id value'));
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(Cart::find($args['id']))
            ->update($args);
    }
    function deleteCart($_, array $args){
        return Cart::destroy($args['id']) > 0 ? true : false;
    }
}