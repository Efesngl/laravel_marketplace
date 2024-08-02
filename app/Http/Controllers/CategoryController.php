<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Specification;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function specs($category_id){
        $category = Specification::with("values:id,value,specification_id")
        ->select("id","specification")
        ->whereRelation("categories","category_id","=",$category_id)
        ->get();
        return response()->json($category);
    }
}
