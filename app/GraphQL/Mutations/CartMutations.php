<?php

namespace App\GraphQL\Mutations;

use App\Jobs\SendEmail;
use App\Models\Cart;
use App\Models\DevProject;
use App\Models\ProjectSellBuy;
use App\Models\SplitRatio;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CartMutations
{
    function createCart($_, array $args){
        if(count($args['products']) == 0){
            throw new Exception('No products added to cart');
        }
        $message = [
            'type' => 'Tạo một giỏ hàng',
            'task' => 'Kiểm tra',
            'content' => 'Bạn đã tạo một giỏ hàng thành công',
            'url'=> '#',
            'img' => URL::to('/logo.png'),
        ];
        $args['user_id'] = Auth::id();
        $products = $args['products'];
        $cart = Cart::create($args);
        foreach ($products as $product){
            $project = DevProject::find($product['id']);
            $project->purchases += 1 ;
            $project->save();
            $split = SplitRatio::create([
                'dev_project_id' => $product['id'],
                'price' => $product['price'],
                'price_dev_recieve' => ($product['price'] * 80) /100,
                'price_admin_recieve' => $product['price'] - ($product['price'] * 80) /100,
            ]);
            ProjectSellBuy::create([
                'project_id' => $project->id,
                'user_sell' => $project->user->id,
                'user_buy' => Auth::id(),
                'status' => 'Chưa tiếp nhận',
                'cart_id' => $cart->id,
                'split_id' => $split->id,
            ]);
        }
        SendEmail::dispatch($message, [Auth::user()]);
        return $cart;
    }
    function editCart($_, array $args){
        if(!isset($args['id'])) throw(new Exception('missing id value'));
        $args = array_diff_key($args, array_flip(['directive']));
        return tap(Cart::find($args['id']))
            ->update($args);
    }
    function deleteCart($_, array $args){
        if(isset($args['force_delete']) && $args['force_delete']) 
            return Cart::destroy($args['id']) > 0 ? true : false;
        $cart = Cart::find($args['id']);
        if($cart->user->id != Auth::id()){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'input.id' => ["Permission denied."],
            ]);
            throw $error;
        }
        $args = array_diff_key($args, array_flip(['directive']));
        return Cart::destroy($args['id']) > 0 ? true : false;
        
    }
    function updateStatus($_, array $args){
        $args = $args['input'];
        try {
            if(isset($args['force_update']) && $args['force_update']){
                $buy_sell = ProjectSellBuy::where('cart_id', $args['cart_id']);
            }else{
                $buy_sell = ProjectSellBuy::where('project_id', $args['project_id'])
                    ->where('cart_id', $args['cart_id'])->limit(1);
            }

        
        return $buy_sell->update(['status' => $args['status']]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
}