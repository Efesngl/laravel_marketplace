<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrowseController extends Controller
{
    //
    public function index(Request $request, $parent = 0)
    {
        if ($parent != 0) {
            $category = Category::with("children")->findOrFail($parent);
            if(count($category->children)==0){
                return redirect(route("deal.index",["cat"=>$category->id]));
            }
        }
        $categories = Category::with("children")->where("parent_id", $parent)->get();
        $parent_category = null;
        if ($parent != 0) {
            $parent_category = Category::where("id", $parent)->first();
        }
        return Inertia::render("Deal/Browse", ["categories" => $categories, "parentCategory" => $parent_category]);
    }
}
