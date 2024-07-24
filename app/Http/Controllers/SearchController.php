<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    //
    public function index()
    {
        return Inertia::render("Deal/Search");
    }

    public function result(Request $request)
    {
        $deals = Deal::where("title", "like", "%{$request->input("search")}%")->get();
        return Inertia::render("Deal/SearchResult", [
            "deals" => $deals,
            "search" => $request->input("search"),
        ]);
    }
}
