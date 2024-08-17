<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $favorites=Favorite::with("product")->where("user_id", auth()->user()->id)->get();
        return Inertia::render("Account/Favorites", [
            "favorites"=>$favorites
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "productID"=>["required","exists:products,id"],
        ]);
        $favorite=new Favorite;
        $favorite->user_id=$request->user()->id;
        $favorite->product_id=$request->productID;
        if(!$favorite->save()){
            return response(500);
        }
        return $favorite->only("id","product_id","user_id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $request->validate([
            "productID"=>["required","exists:products,id"],
        ]);
        if(!Favorite::where("product_id",$request->productID)->where("user_id",$request->user()->id)->delete()){
            return response("",500);
        }
        return response("",200);
    }
}
