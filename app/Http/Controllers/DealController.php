<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Deal;
use App\Models\DealImage;
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
        $categories = Category::with("children:category,parent_id,id,can_have_children", "specifications")->where("parent_id", 0)->select("category", "parent_id", "id", "can_have_children")->get();
        $tree = $this->category_tree($categories);
        $locations = City::with("districts.neighbourhoods")->get();
        return Inertia::render("Deal/Create", [
            "categories" => $tree,
            "locations" => $locations
        ]);
    }
    public function category_tree($categories, $index = "0", $isChild = false)
    {
        $tree = [];
        foreach ($categories as $key => $cat) {
            # code...
            $node = [
                "key" => (!$isChild) ? $index : "{$index}-{$key}",
                "label" => $cat->category,
                "id" => $cat->id,
            ];
            if (count($cat->children) > 0) {
                $node["selectable"] = false;
                $node["children"] = $this->category_tree($cat->children, $node["key"], true);
            }
            array_push($tree, $node);
            if (!$isChild) {
                $index++;
            }
        }
        return $tree;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            "title" => ["required"],
            "price" => ["required", "decimal:0,2", "gt:1"],
            "description" => ["required", ""],
            "category" => ["required", ""],
            "banner" => ["required", "image"],
            "images" => ["required", "array"],
            "city" => ["required", "integer"],
            "district" => ["required", "integer"],
            "nh" => ["required", "integer"],
            "specifications" => ["required", "array"],
        ]);
        $deal = new Deal;
        $deal->title = $validated["title"];
        $deal->price = $validated["price"];
        $deal->description = $validated["description"];
        $deal->city_id = $validated["city"];
        $deal->district_id = $validated["district"];
        $deal->neighbourhood_id = $validated["nh"];
        $deal->category_id = $validated["category"];
        $deal->is_active = 1;
        $deal->user_id = $request->user()->id;
        $deal->banner = str_replace("public/", "", $request->file("banner")->store("public/images/banners"));
        if ($deal->save()) {
            $imageArr = [];
            foreach ($request->file("images") as $file) {
                array_push($imageArr, ["deal_id" => $deal->id, "image" => str_replace("public/", "", $file->store("public/images/{$deal->id}"))]);
            }
            $deal->images()->insert($imageArr);
            $specArr = [];
            foreach ($validated["specifications"] as $spec) {
                array_push($specArr, ["deal_id" => $deal->id, "specification_id" => $spec["specification_id"], "value_id" => $spec["id"]]);
            }
            $deal->specifications()->insert($specArr);
        }
        return response("", 201);
    }
    public function uploadPhotos(Request $request, $is_banner = false)
    {
        return $request->file("banner");
    }
    public function deleteImage($id)
    {
        DealImage::destroy($id);
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
            "specifications.value:id,value",
            "images:deal_id,image,id"
        ])->findOrFail($id);
        if($deal->is_active==false){
            abort(404);
        }
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
        $deal = Deal::with([
            "city:name,id",
            "district:name,id,city_id",
            "neighbourhood:name,id,district_id",
            "category",
            "images",
            "specifications",
        ])->findOrFail($id);

        $categories = Category::with("children:category,parent_id,id,can_have_children", "specifications")->where("parent_id", 0)->select("category", "parent_id", "id", "can_have_children")->get();
        $tree = $this->category_tree($categories, $deal->category_id);
        $locations = City::with("districts:name,id,city_id", "districts.neighbourhoods:name,id,district_id")->select("name", "id")->get();
        return Inertia::render("Deal/Edit", [
            "dealProp" => $deal,
            "categories" => $tree,
            "locations" => $locations
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            "title" => ["required"],
            "price" => ["required", "decimal:0,2", "gt:1"],
            "description" => ["required", ""],
            "category" => ["required", ""],
            "city" => ["required", "integer"],
            "district" => ["required", "integer"],
            "nh" => ["required", "integer"],
            "specifications" => ["required", "array"],
            "isActive"=>["required","boolean"]
        ]);
        $deal = Deal::with("images", "specifications")->findOrFail($id);
        $deal->title = $validated["title"];
        $deal->price = $validated["price"];
        $deal->description = $validated["description"];
        $deal->city_id = $validated["city"];
        $deal->district_id = $validated["district"];
        $deal->neighbourhood_id = $validated["nh"];
        $deal->category_id = $validated["category"];
        $deal->is_active = $validated["isActive"];
        if ($request->hasFile("banner")) {
            $deal->banner = str_replace("public/", "", $request->file("banner")->store("public/images/banners"));
        }
        if ($request->hasFile("images")) {
            $imageArr = [];
            foreach ($request->file("images") as $file) {
                array_push($imageArr, ["deal_id" => $deal->id, "image" => str_replace("public/", "", $file->store("public/images/{$deal->id}"))]);
            }
            $deal->images()->insert($imageArr);
        }
        foreach ($deal->specifications as $spec) {
            $spec->value_id = $validated["specifications"][$spec->specification_id]["value_id"];
            if ($spec->isDirty()) {
                $spec->save();
            }
        }
        if ($deal->isDirty()) {
            $deal->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
