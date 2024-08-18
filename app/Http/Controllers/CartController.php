<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "quantity" => ["required", "integer"]
        ]);
        $cartItem = ShoppingCart::findOrFail($id);
        if ($request->quantity == 0) {
            if ($cartItem->delete())
                return response("", 200);
        } else {
            $cartItem->quantity = $request->quantity;
            if ($cartItem->save())
                return response("", 200);
        }
        return response("", 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
