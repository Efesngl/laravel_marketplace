<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\City;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = $request->rows ?? 50;
        $cat_id = $request->input("cat");
        $category = null;
        $products = Product::paginate($rows);
        if ($cat_id != 0) {
            $category = Category::findOrFail($cat_id);
            $products = Product::where("category_id", $category->id)->paginate($rows);
            if ($category->can_have_children == 1) {
                $products = Product::whereRelation("category.parent", "parent_id", "=", $cat_id)->orWhereRelation("category", "parent_id", "=", $cat_id)->paginate($rows);
            }
        }
        return Inertia::render("Product/Index", [
            "category" => (is_null($category)) ? 'All Products' : $category->category,
            "products" => $products,
            "catID" => intval($cat_id),
            "rowAmount" => intval($rows)
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
        return Inertia::render("Product/Create", [
            "categories" => $tree,
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
        $request->validate([
            "title" => ["required"],
            "price" => ["required", "decimal:0,2", "gt:1"],
            "description" => ["required", ""],
            "category" => ["required", ""],
            "banner" => ["required", "image"],
            "images" => ["required", "array"],
            "specifications" => ["required", "array"],
            "stock" => ["required", "integer", "gt:0"],
            "quantityPerUser" => ["required", "integer"]
        ]);
        $product = new Product;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->is_active = 1;
        $product->stock = $request->stock;
        $product->quantity_per_user = $request->quantityPerUser;
        $product->user_id = $request->user()->id;
        $product->banner = str_replace("public/", "", $request->file("banner")->store("public/images/banners"));
        if ($product->save()) {
            $imageArr = [];
            foreach ($request->file("images") as $file) {
                $imageArr[] = new ProductImage(["image" => str_replace("public/", "", $file->store("public/images/{$product->id}"))]);
            }
            $product->images()->saveMany($imageArr);
            $specArr = [];
            foreach ($request->specifications as $spec) {
                $specArr[]= new ProductSpecification(["specification_id" => $spec["specification_id"], "value_id" => $spec["id"]]);
            }
            $product->specifications()->saveMany($specArr);
            return response("", 201);
        }
        return response("", 500);
    }
    public function uploadPhotos(Request $request, $is_banner = false)
    {
        return $request->file("banner");
    }
    public function deleteImage($id)
    {
        ProductImage::destroy($id);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $product = Product::with([
            "chats.users",
            "user:id,name,email,phone_number",
            "specifications.specification:id,specification",
            "specifications.value:id,value",
            "images:product_id,image,id",
        ])->findOrFail($id);
        $product->favorites_count = null;
        if (!is_null(auth()->user())) {
            $product->loadCount([
                "favorites" => function (\Illuminate\Database\Eloquent\Builder $builder) {
                    $builder->where("user_id", auth()->user()->id);
                }
            ]);
        }
        $user_chat = null;
        if (!is_null(auth()->user())) {
            $user_chat = Chat::where("product_id", $id)->whereRelation("users", "user_id", auth()->user()->id)->select("id")->first();
        }
        if ($product->is_active == false) {
            abort(404);
        }
        return Inertia::render("Product/Detail", [
            "product" => $product,
            "chat" => $user_chat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
            $product = Product::with([
            "category",
            "images",
            "specifications",
        ])->findOrFail($id);
        $categories = Category::with("children:category,parent_id,id,can_have_children", "specifications")->where("parent_id", 0)->select("category", "parent_id", "id", "can_have_children")->get();
        $tree = $this->category_tree($categories, $product->category_id);
        return Inertia::render("Product/Edit", [
            "productProp" => $product,
            "categories" => $tree,
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
            "isActive" => ["required", "boolean"],
            "isSelled" => ["required", "boolean"]
        ]);
        $product = Product::with("images", "specifications")->findOrFail($id);
        $product->title = $validated["title"];
        $product->price = $validated["price"];
        $product->description = $validated["description"];
        $product->city_id = $validated["city"];
        $product->district_id = $validated["district"];
        $product->neighbourhood_id = $validated["nh"];
        $product->category_id = $validated["category"];
        $product->is_active = $validated["isActive"];
        $product->is_selled = $validated["isSelled"];
        if ($request->hasFile("banner")) {
            $product->banner = str_replace("public/", "", $request->file("banner")->store("public/images/banners"));
        }
        if ($request->hasFile("images")) {
            $imageArr = [];
            foreach ($request->file("images") as $file) {
                array_push($imageArr, ["image" => str_replace("public/", "", $file->store("public/images/{$product->id}"))]);
            }
            $product->images()->insert($imageArr);
        }
        foreach ($product->specifications as $spec) {
            $spec->value_id = $validated["specifications"][$spec->specification_id]["value_id"];
            if ($spec->isDirty()) {
                $spec->save();
            }
        }
        if ($product->isDirty()) {
            $product->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Product::destroy($id);
        return to_route("account.index");
    }
}
