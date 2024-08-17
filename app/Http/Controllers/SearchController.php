<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    //
    public function index()
    {
        return Inertia::render("Search/Search");
    }

    public function result(Request $request)
    {
        $rows=$request->rows ?? 50;
        $products = Product::where("title", "like", "%{$request->input("search")}%")->paginate($rows);
        return Inertia::render("Search/SearchResult", [
            "products" => $products,
            "search" => $request->input("search"),
            "rowAmount"=>$rows
        ]);
    }
}
