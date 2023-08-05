<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop(){
        $products = Product::all();

        return view('cart.shop', compact('products'));
    }

    public function cart(){
//        $product = Product::findOrFail();
        $items = Cart::content();

        return view('cart.cart', compact('items'));
    }

    public function addToCart($product_id){
        $product = Product::findOrFail($product_id);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 550,
            'options' => ['image' => $product->image]
        ]);

        return redirect()->back()->with('success', 'Product Has Been Added To Your Cart!');
//        Cart::add();

    }
    public function removeFromCart($rowId){
        Cart::remove($rowId);

        return redirect()->back();
    }

    public function clearCart(){
        Cart::destroy();

        return redirect()->back();
    }

    public function qtyIncrement($rowId){
        $item = Cart::get($rowId);
        $new_qty = $item->qty+1;
        Cart::update($rowId, $new_qty);
    return redirect()->back()->with('success', 'Product Quantity Has Increased Successfully!');
    }

    public function qtyDecrement($rowId){
        $item = Cart::get($rowId);
        $new_qty = $item->qty-1;
        if($new_qty > 0){
            Cart::update($rowId, $new_qty);
        }
        else{
            return redirect()->back()->with('success', 'Product Quantity Cannot Be Less Than 0');
        }
        return redirect()->back()->with('success', 'Product Quantity Has Decreased Successfully!');
    }
}
