<?php

namespace App\GraphQL\Mutations;

use App\Jobs\SendEmail;
use App\Models\Cart;
use App\Models\DevProject;
use App\Models\SplitRatio;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartMutations
{
    function createCart($_, array $args){
        $message = [
            'type' => 'Tạo một giỏ hàng',
            'task' => 'Kiểm tra',
            'content' => 'Bạn đã tạo một giỏ hàng thành công',
            'url'=> '#'
        ];
        SendEmail::dispatch($message, [Auth::user()]);
        $args['user_id'] = Auth::id();
        // $cart = Cart::create($args);
        $products = $args['products'];
        foreach ($products as $product){
            $project = DevProject::find($product['id']);
            $project->purchases += 1 ;
            $project->save();
            SplitRatio::create([
                'dev_project_id' => $product['id'],
                'price' => $product['price'],
                'price_dev_recieve' => ($product['price'] * 80) /100,
                'price_admin_recieve' => $product['price'] - ($product['price'] * 80) /100,
            ]);
        }
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