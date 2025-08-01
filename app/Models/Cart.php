<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class Cart extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for Cart model
     * Based on SQL: CREATE TABLE `carts` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
    ];

    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_CANCELLED = 2;

    function add_to_cart($product_id, $quantity, $uid)
    {
        //Kiểm tra xem có cart nao chua thanh toan thi them vao
        if($cart = Cart::where('user_id', $uid)->where('status', Cart::STATUS_PENDING)->first()){
            //Da co cart
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();
            if($cartItem){
                $cartItem->quantity += $quantity;
                $cartItem->save();
            }else{
                $cartItem = new CartItem();
                $cartItem->user_id = $uid;
                $cartItem->cart_id = $cart->id;
                $cartItem->product_id = $product_id;
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }
        else{
            //Chua co cart
            $cart = new Cart();
            $cart->user_id = $uid;
            $cart->status = Cart::STATUS_PENDING;
            $cart->save();

            $cartItem = new CartItem();
            $cartItem->user_id = $uid;
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $product_id;
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
    }
}
