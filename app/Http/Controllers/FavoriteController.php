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
        $favorites=Favorite::with("deal")->where("user_id", auth()->user()->id)->get();
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
            "dealID"=>["required","exists:deals,id"],
        ]);
        $favorite=new Favorite;
        $favorite->user_id=$request->user()->id;
        $favorite->deal_id=$request->dealID;
        if(!$favorite->save()){
            return response(500);
        }
        return $favorite->only("id","deal_id","user_id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if(!Favorite::destroy($id)){
            return response(500);
        }
        return response(200);
    }
}
