<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deal;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cat_id = $request->input("cat");
        $category = "All";
        $deals = Deal::all();
        if ($cat_id != 0) {
            $category = Category::findOrFail($cat_id);
            $deals = Deal::where("category_id", $category->id)->get();
            if ($category->can_have_children == 1) {
                $deals = Deal::whereRelation("category.parent", "parent_id", "=", $cat_id)->orWhereRelation("category", "parent_id", "=", $cat_id)->get();
            }
        }
        return Inertia::render("Deal/Index", [
            "category" => $category,
            "deals" => $deals
        ]);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $deal = Deal::with([
            "neighbourhood:name,id,district_id",
            "district:name,id",
            "city:name,id",
            "user:id,name,email,phone_number",
            "specifications.specification:id,specification",
            "specifications.value:id,value"
        ])->findOrFail($id);
        return Inertia::render("Deal/DealDetail", [
            "deal" => $deal
        ]);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
