<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ShoppingCart;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cart = auth()->user()->cart()->with("product")->get();
        $total = 0;
        foreach ($cart as $c) {
            # code...
            if ($c->selected)
                $total += $c->quantity * $c->product->price;
        }
        return Inertia::render("Cart/Index", [
            "cart" => $cart,
            "total" => number_format($total, 2, ",", ".")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "productID" => ["required", "exists:products,id"],
        ]);
        $cart = new ShoppingCart;
        $cart->product_id = $request->productID;
        $cart->user_id = $request->user()->id;
        $cart->quantity = 1;
        if ($cart->save()) {
            return response("", 200);
        }
        return response("", 500);
    }
    public function setQuantity(Request $request, string $id)
    {
        $request->validate([
            "quantity" => ["required", "integer"],
            "type" => ["required", "string"]
        ]);
        $cartItem = ShoppingCart::findOrFail($id);
        if ($request->quantity == 0) {
            $cartItem->delete();
        } else {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }
        return to_route("cart.index");
    }
    public function setSelected(Request $request, string $id)
    {
        $request->validate([
            "selected" => ["required", "boolean"],
        ]);
        $cartItem = ShoppingCart::findOrFail($id);
        $cartItem->selected = $request->selected;
        $cartItem->save();
        return to_route("cart.index");
    }
    public function checkout()
    {

        try{
            DB::beginTransaction();
            $total = 0;
            $cart = auth()->user()->cart()->get();
            foreach ($cart as $c) {
                $total += $c->quantity * $c->product->price;
            }
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->total = $total;
            $order->address = "Address";
            $order->save();
            $orderProductsArr=[];
            foreach($cart as $c){
                $orderProductsArr[]=new OrderProduct(["product_id"=>$c->product->id,"status_id"=>1,"quantity"=>$c->quantity]);
            }
            $order->products()->saveMany($orderProductsArr);
            auth()->user()->cart()->delete();
            DB::commit();
            return $order->load("products");
        }
        catch(\Exception $e){
            DB::rollBack();
            return $e;  
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function clear()
    {
        //
        auth()->user()->cart()->delete();
        return to_route("cart.index");
    }
}
